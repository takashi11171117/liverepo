<?php

namespace App\Listeners;

use App\Events\FrontReportPostEvent;
use App\Models\Report;
use App\Repositories\Contracts\ReportImageRepository;
use App\Repositories\Contracts\ReportRepository;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
use Rx\Observable;

class FrontReportPostListener
{
    protected $reports;

    protected $image_service;

    /**
     * FrontReportPostListener constructor.
     * @param ReportRepository $reports
     * @param ImageService $image_service
     * @throws \Exception
     */
    public function __construct(ReportRepository $reports, ReportImageRepository $report_images, ImageService $image_service)
    {
        $this->reports       = $reports;
        $this->report_images = $report_images;
        $this->image_service = $image_service;
    }

    /**
     * @param FrontReportPostEvent $event
     * @throws \Throwable
     */
    public function handle(FrontReportPostEvent $event)
    {
        $request = $event->request;
        $id = $event->id;

        DB::transaction(function () use ($request, $id) {
            $params = $request->all();
            $images = $request->file('images');

            $report = $this->reports->save($params, $id);

            $this->registerTags($request, $report);
            $this->registerImages($report, $images);
        });
    }

    private function registerTags(Request $request, Report $report)
    {
        Observable::fromArray(['place_tags', 'player_tags', 'other_tags'])
                  ->map(function ($value) use ($request) {
                      return array_map(
                          function ($v) use ($value) {
                              return [
                                  'taxonomy' => str_replace('_tags', '', $value),
                                  'name'     => $v
                              ];
                          },
                          json_decode($request->get($value))
                      );
                  })
                  ->filter(function ($value) {
                      if (isset($value[0]['name'])) {
                          return $value[0]['name'] !== '';
                      }
                      return true;
                  })
                  ->reduce(function ($x, $y) {
                      return array_merge($x, $y);
                  })
                  ->subscribe(
                      function ($tags) use ($report) {
                          $this->reports->syncReportTag($report, $tags);
                      },
                      function (\Exception $ex) {
                      },
                      function () {
                      });
    }

    private function registerImages(Report $report, $images)
    {
        if (!empty($images)) {
            foreach ($images as $key => $image) {
                $tmpFilename = $report->id . '_' .  sprintf('%02d', ($key + 1));
                $filename = $this->image_service->createReportImage($tmpFilename, $image);

                try {
                    $report_image = $this->report_images->findByName($tmpFilename);
                    $this->report_images->update($report_image->id, ['path' => $filename]);
                } catch(\Exception $e) {
                    $this->reports->createImages($report, $filename);
                }
            }
        }
    }
}

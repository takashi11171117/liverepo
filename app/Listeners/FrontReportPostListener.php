<?php

namespace App\Listeners;

use App\Events\FrontReportPostEvent;
use App\Models\Report;
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
    public function __construct(ReportRepository $reports, ImageService $image_service)
    {
        $this->reports       = $reports;
        $this->image_service = $image_service;
    }

    /**
     * @param FrontReportPostEvent $event
     * @throws \Throwable
     */
    public function handle(FrontReportPostEvent $event, int $id = 0)
    {
        $request = $event->request;

        DB::transaction(function () use ($request, $id) {
            $params = $request->all();
            $images = $request->file('images');

            $report = $this->reports->save(\Auth::user(), $params, $id);

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
                          explode(',', $request->get($value))
                      );
                  })
                  ->filter(function ($value) {
                      return $value[0]['name'] !== '';
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
            $filename = $this->image_service->createReportImage($report, $images[0]);
            $this->reports->createImages($report, $filename);
        }
    }
}

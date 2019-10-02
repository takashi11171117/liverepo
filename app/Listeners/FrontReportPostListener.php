<?php

namespace App\Listeners;

use App\Events\FrontReportPostEvent;
use App\Models\User;
use App\Repositories\Contracts\ReportRepository;
use App\Services\ImageService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
use Rx\Observable;
use Rx\Scheduler;
use Rx\Scheduler\ImmediateScheduler;

class FrontReportPostListener
{
    protected $reports;

    protected $image_service;

    public function __construct(ReportRepository $reports, ImageService $image_service)
    {
        $this->reports       = $reports;
        $this->image_service = $image_service;
    }

    /**
     * @param FrontReportPostEvent $event
     * @throws \Throwable
     */
    public function handle(FrontReportPostEvent $event)
    {
        $params = $event->params;
        $request = $event->request;
        $images = $event->images;
        $user_id = $event->user_id;

        DB::transaction(function () use ($params, $request, $images, $user_id) {
            $user   = User::find($user_id);
            $report = $this->reports->save($user, $params);

            // タグの登録
            $immediateScheduler = new ImmediateScheduler();
            Scheduler::setDefaultFactory(function () use ($immediateScheduler) {
                return $immediateScheduler;
            });

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
                          function ($tags) {
                              $this->reports->syncReportTag($report, $tags);
                          },
                          function (\Exception $ex) {
                          },
                          function () {
                          });

            // 画像の登録
            if (!empty($images)) {
                $filename = $this->image_service->createReportImage($report, $images[0]);
                $this->reports->createImages($report, $filename);
            }
        });
    }
}

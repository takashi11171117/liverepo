<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\User\Report\Post;
use App\Http\Resources\Front\UserReportIndexResource;
use App\Http\Resources\Front\UserReportResource;
use App\Models\Report;
use App\Models\User;
use App\Services\ReportService;
use DB;
use Storage;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $report_service)
    {
        $this->reportService = $report_service;
    }

    public function index($user_id)
    {
        $reports = User::find($user_id)->reports()->paginate(10);

        return UserReportIndexResource::collection($reports);
    }

    /**
     * @return mixed
     * @throws \Throwable
     */
    public function store(Post $request, $user_id)
    {
        $params = $request->all();
        $report = new Report();
        $images = $request->file('images');
        $temp_tags = explode(',', $request->get('tags'));

        DB::transaction(function () use ($report, $params, $temp_tags, $images, $user_id) {
            $report->user()->associate(User::find($user_id));

            $report->fill($params)->save();

            // タグの登録
            $this->reportService->syncReportTag($report, $temp_tags);

            // 画像の登録
            $disk = Storage::disk('s3');

            $file = $images[0];
            $extension = $images[0]->getClientOriginalExtension();
            $filename = "{$report->id}_01.$extension";

            $image = \Image::make($file)
                           ->resize(1024, null, function ($constraint) {
                               $constraint->aspectRatio();
                           });
            $disk->put('report_images/' . $filename, (string) $image->encode());

            $image = \Image::make($file)
                           ->fit(300, 300);
            $disk->put('report_images/thumb-' . $filename, (string) $image->encode());

            $report->report_images()->create(['path'=> $filename]);
        });

        return new UserReportResource($report);
    }
}

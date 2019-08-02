<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\User\Report\Post as ReportPost;
use App\Http\Requests\Front\User\Profile\Post as ProfilePost;
use App\Http\Resources\Front\UserReportIndexResource;
use App\Http\Resources\Front\UserReportResource;
use App\Models\Report;
use App\Models\User;
use App\Services\ReportService;
use DB;
use Illuminate\Http\Request;
use Storage;

class SettingController extends Controller
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
    public function post(ReportPost $request, $user_id)
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

    /**
     * @param Request $request
     * @param $id
     */
    public function profile(ProfilePost $request)
    {
        $user_id = $request->get('user_id');
        $user = User::find($user_id);

        $args = $request->only([
            'user_name01',
            'user_name02',
            'show_mail_flg',
            'url',
            'description',
            'gender',
            'birth',
        ]);

        $file = $request->file('image');

        if ($file !== null) {
            // 画像の登録
            $disk = Storage::disk('s3');

            $extension = $file->getClientOriginalExtension();
            $filename  = "{$user_id}_icon.$extension";

            $image = \Image::make($file)
                           ->fit(500, 500);
            $disk->put('profile_images/' . $filename, (string)$image->encode());

            $image = \Image::make($file)
                           ->fit(100, 100);
            $disk->put('profile_images/thumb-' . $filename, (string)$image->encode());

            $args['image_path'] = $filename;
        }

        $user->update($args);
    }
}

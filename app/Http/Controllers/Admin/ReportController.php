<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Report\Post;
use App\Http\Requests\Admin\Report\Put;
use App\Http\Resources\Admin\ReportIndexResourse;
use App\Http\Resources\Admin\ReportResourse;
use App\Scoping\Scopes\ReportSearchScope;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\ReportService;
use Storage;
use DB;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $report_service)
    {
        $this->reportService = $report_service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $perPage = 20;
        if ($request->input('per_page') !== null) {
            $perPage = (int) $request->input('per_page');
        }

        $reports = Report::withScopes($this->scopes())
                       ->paginate($perPage);

        return ReportIndexResourse::collection($reports);
    }

    /**
     * @return mixed
     * @throws \Throwable
     */
    public function store(Post $request)
    {
        $params = $request->all();
        $report = new Report;
        $images = $request->file('images');
        $temp_place_tags = explode(',', $request->get('place_tags'));
        $temp_player_tags = explode(',', $request->get('player_tags'));
        $temp_other_tags = explode(',', $request->get('other_tags'));

        DB::transaction(function () use ($report, $params, $temp_place_tags, $temp_player_tags, $temp_other_tags, $images) {
            $report->fill($params)->save();

            // タグの登録
            $this->reportService->syncReportTag($report, $temp_place_tags, 'place');
            $this->reportService->syncReportTag($report, $temp_player_tags, 'player');
            $this->reportService->syncReportTag($report, $temp_other_tags, 'other');

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

        return new ReportResourse($report);
    }

    /**
     * @param $id
     * @return ReportResourse
     */
    public function show($id)
    {
        $report = Report::with(['report_images', 'report_tags'])->find($id);

        if($report == null) {
            return response()->json(['error' => 'レポートはありません。'], 404);
        }

        return new ReportResourse($report);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Throwable
     */
    public function update(Put $request, $id)
    {
        $params = $request->all();
        $report = Report::find($id);

        if($report == null) {
            return response()->json(['error' => 'レポートはありません。'], 404);
        }

        $images = $request->file('images');
        $temp_tags = explode(',', $request->get('tags'));
        $tags = array_map(function($tag) {
            return ['name' => $tag, 'taxonomy' => 'place'];
        }, $temp_tags);

        DB::transaction(function () use ($report, $params, $tags, $images) {
            // 普通のパラメーター
            $report->fill($params)->save();

            // タグの登録
            $report->report_tags()->createMany($tags);


            // 画像の登録

            if ($images !== null) {
                $disk = Storage::disk('s3');

                $file      = $images[0];
                $extension = $images[0]->getClientOriginalExtension();
                $filename  = $report->id . '_01' . ".$extension";
                $image = \Image::make($file)
                           ->resize(1024, null, function ($constraint) {
                               $constraint->aspectRatio();
                           });
                $disk->put('report_images/' . $filename, (string)$image->encode());
                $image = \Image::make($file)
                               ->fit(300, 300);
                $disk->put('report_images/thumb-' . $filename, (string)$image->encode());

                $report->report_images()->create(['path' => $filename]);
            }
        });

        return new ReportResourse($report);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $report = Report::find($id);

        if($report == null) {
            return response()->json(['error' => 'レポートはありません。'], 404);
        }

        $report->delete();

        $args = [];

        $query = $request->query();

        if (array_key_exists('page', $query)) {
            $args['page'] = $request->page;
        }

        if (array_key_exists('per_page', $query)) {
            $args['per_page'] = $request->per_page;
        }

        if (array_key_exists('s', $query)) {
            $args['s'] = $request->s;
        }

        return redirect()->route('admin.reports.index', $args, 301);
    }

    protected function scopes()
    {
        return [
            's' => new ReportSearchScope()
        ];
    }
}

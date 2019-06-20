<?php

namespace App\Http\Controllers\Front;

use App\Http\Resources\Front\ReportResource;
use App\Http\Resources\Front\ReportIndexResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Report;

class ReportController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $reports = Report::with([
            'report_images',
        ])->status(config('const.PUBLISH'))->paginate(20);

        return ReportIndexResource::collection($reports);
    }

    /**
     * @param $id
     * @return ReportResource
     */
    public function show($id)
    {
        $report = Report::with(['report_images', 'report_tags', 'user'])->find($id);

        if($report == null) {
            return response()->json(['error' => 'レポートはありません。'], 404);
        }

        return new ReportResource($report);
    }
}

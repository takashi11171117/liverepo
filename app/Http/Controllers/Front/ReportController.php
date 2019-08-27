<?php

namespace App\Http\Controllers\Front;

use App\Http\Resources\Front\ReportResource;
use App\Http\Resources\Front\ReportIndexResource;
use App\Scoping\Scopes\ReportDateScope;
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
        $reports = Report::withScopes($this->scopes())
                         ->with([
                            'report_images',
                        ])->orderBy('created_at', 'desc')
                        ->status(config('const.PUBLISH'))
                        ->paginate(20);

        return ReportIndexResource::collection($reports);
    }

    /**
     * @param $id
     * @return ReportResource
     */
    public function show(int $id)
    {
        $report = Report::with(['report_images', 'report_tags', 'user', 'report_comments'])
                        ->withCount('followers')
                        ->find($id);

        if($report === null) {
            return response()->json(['error' => 'レポートはありません。'], 404);
        }

        return new ReportResource($report);
    }

    protected function scopes()
    {
        return [
            'date' => new ReportDateScope()
        ];
    }
}

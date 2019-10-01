<?php

namespace App\Http\Controllers\Front;

use App\Http\Resources\Front\ReportResource;
use App\Http\Resources\Front\ReportIndexResource;
use App\Http\Resources\Front\ReportTagResource;
use App\Models\ReportTag;
use App\Repositories\Contracts\ReportRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Report;
use DB;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportController extends Controller
{
    protected $reports;

    public function __construct(ReportRepository $reports)
    {
        $this->reports = $reports;
    }

    public function index() : AnonymousResourceCollection
    {
        $reports = $this->reports->paginate(20);

        return ReportIndexResource::collection($reports);
    }

    public function isExistingReportByDate(Request $request)
    {
        $month = $request->get('month');

        $reportDates = Report::select(DB::raw("count(*) as count, strftime('%Y-%m-%d', published_at) as formatted_published_at"))
                ->status(config('const.PUBLISH'))
                ->whereRaw("strftime('%Y-%m', published_at) = :month", ['month' => $month])
                ->groupBy('formatted_published_at')
                ->orderBy('formatted_published_at', 'desc')
                ->get();

        return response()->json($reportDates, 200);
    }

    public function getReportTagsWithReportsByDate(Request $request)
    {
        $date = $request->get('date');

        $temp_tags = DB::select('SELECT rt.id FROM reports rp
          INNER JOIN report_report_tag rrt
          ON rp.id = rrt.report_id
          INNER JOIN report_tags rt
          ON rrt.report_tag_id = rt.id
          WHERE published_at LIKE ?
          AND rt.taxonomy = "place"
          GROUP BY rt.id', ["%$date%"]);

        $tags = [];
        foreach($temp_tags as $tag) {
            $tags[] = $tag->id;
        }

        $report_tags = ReportTag::with([
            'reports',
        ])->whereIn('id', $tags)
        ->get();

        return ReportTagResource::collection($report_tags);
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

<?php

namespace App\Http\Controllers\Admin;

use App\Events\FrontReportPostEvent;
use App\Http\Requests\Admin\Report\Post;
use App\Http\Requests\Admin\Report\Put;
use App\Http\Resources\Admin\ReportIndexResourse;
use App\Http\Resources\Admin\ReportResourse;
use App\Repositories\Contracts\ReportRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportController extends Controller
{
    protected $reports;

    public function __construct(ReportRepository $reports)
    {
        $this->reports = $reports;
    }

    /**
     * @param Request $request
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = 20;
        if ($request->input('per_page') !== null) {
            $perPage = (int) $request->input('per_page');
        }

        $reports = $this->reports->paginate($perPage);

        return ReportIndexResourse::collection($reports);
    }

    /**
     * @throws \Throwable
     */
    public function store(Post $request): void
    {
        event(new FrontReportPostEvent($request));
    }

    /**
     * @param $id
     * @return ReportResourse
     */
    public function show($id)
    {
        $report = $this->reports->findWithRelations($id);

        return new ReportResourse($report);
    }

    /**
     * @throws \Throwable
     */
    public function update(Put $request, int $id): void
    {
        event(new FrontReportPostEvent($request, $id));
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
}

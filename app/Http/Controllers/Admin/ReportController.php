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
use Rx\Observable;

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
            $perPage = (int)$request->input('per_page');
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->reports->delete($id);

        Observable::fromArray(['page', 'per_page', 's'])
                  ->filter(function ($value) use ($request) {
                      return array_key_exists($value, $request->query());
                  })
                  ->map(function ($value) use ($request) {
                      return $request[$value];
                  })
                  ->toArray()
                  ->subscribe(
                      function ($params) {
                          return redirect()->route('admin.reports.index', $params, 301);
                      });
    }
}

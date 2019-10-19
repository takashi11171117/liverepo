<?php

namespace App\Http\Controllers\Front;

use App\Http\Resources\Front\ReportResource;
use App\Http\Resources\Front\ReportIndexResource;
use App\Http\Resources\Front\ReportTagWithReportResource;
use App\Repositories\Contracts\ReportRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Events\FrontReportPostEvent;
use App\Http\Requests\Front\Report\Post;

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

    public function findListByUser(string $name) : AnonymousResourceCollection
    {
        $reports = $this->reports->paginateByUser($name, 20);

        return ReportIndexResource::collection($reports);
    }

    public function findListByReportTag(string $name) : AnonymousResourceCollection
    {
        $reports = $this->reports->paginateByReportTag($name, 20);

        return ReportIndexResource::collection($reports);
    }

    public function findListByMonth(string $month) : JsonResponse
    {
        $reports = $this->reports->findListByMonth($month);

        return response()->json($reports, 200);
    }

    public function findListByDate(string $date) : AnonymousResourceCollection
    {
        $reports = $this->reports->findListByDate($date);

        return ReportTagWithReportResource::collection($reports);
    }

    public function show(int $id) : ReportResource
    {
        $report = $this->reports->findWithRelations($id);

        return new ReportResource($report);
    }

    /**
     * @throws \Throwable
     */
    public function post(Post $request): void
    {
        event(new FrontReportPostEvent($request));
    }
}

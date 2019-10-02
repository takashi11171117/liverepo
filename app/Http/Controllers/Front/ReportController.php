<?php

namespace App\Http\Controllers\Front;

use App\Http\Resources\Front\ReportResource;
use App\Http\Resources\Front\ReportIndexResource;
use App\Http\Resources\Front\ReportTagResource;
use App\Repositories\Contracts\ReportRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
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

    public function findListByMonth(string $month) : JsonResponse
    {
        $reports = $this->reports->findListByMonth($month);

        return response()->json($reports, 200);
    }

    public function findListByDate(string $date) : AnonymousResourceCollection
    {
        $reports = $this->reports->findListByDate($date);

        return ReportTagResource::collection($reports);
    }

    public function show(int $id) : ReportResource
    {
        $report = $this->reports->find($id);

        return new ReportResource($report);
    }
}

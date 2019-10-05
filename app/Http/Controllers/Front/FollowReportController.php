<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\FollowReportRepository;
use App\Repositories\Contracts\ReportRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowReportController extends Controller
{
    protected $follow_reports, $reports;

    public function __construct(FollowReportRepository $follow_reports, ReportRepository $reports)
    {
        $this->follow_reports = $follow_reports;
        $this->reports = $reports;
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            ['result' => $this->follow_reports->find($id)]
        );
    }

    public function store(Request $request): JsonResponse
    {
        $params = [
            'user_id' => \Auth::id(),
            'report_id' => ($this->reports->find(
                (int) $request->input('id') ?? 0
            ))->id
        ];

        $this->follow_reports->create($params);

        return response()->json(['result' => true]);
    }

    public function destroy($id): JsonResponse
    {
        $this->follow_reports->detach($id);

        return response()->json(['result' => true]);
    }
}

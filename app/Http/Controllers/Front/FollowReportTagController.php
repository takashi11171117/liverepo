<?php

namespace App\Http\Controllers\Front;

use App\Repositories\Contracts\FollowReportTagRepository;
use App\Repositories\Contracts\ReportTagRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FollowReportTagController extends Controller
{
    protected $follow_report_tags, $report_tags;

    public function __construct(FollowReportTagRepository $follow_report_tags, ReportTagRepository $report_tags)
    {
        $this->follow_report_tags = $follow_report_tags;
        $this->report_tags = $report_tags;
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            ['data' => $this->follow_report_tags->find($id)]
        );
    }

    public function store(Request $request): JsonResponse
    {
        $params = [
            'user_id' => \Auth::id(),
            'report_tag_id' => ($this->report_tags->find(
                (int) $request->input('id') ?? 0
            ))->id
        ];

        $this->follow_report_tags->create($params);

        return response()->json(['result' => true]);
    }

    public function destroy($id): JsonResponse
    {
        $this->follow_report_tags->detach($id);

        return response()->json(['result' => true]);
    }
}

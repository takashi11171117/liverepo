<?php

namespace App\Http\Controllers\Front;

use App\Repositories\Contracts\ReportCommentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportCommentController extends Controller
{
    protected $report_comments;

    public function __construct(ReportCommentRepository $report_comments)
    {
        $this->report_comments = $report_comments;
    }

    public function store(Request $request): void
    {
        $params = $request->only('body', 'report_id');
        $params['user_id'] = \Auth::id();

        $this->report_comments->create($params);
    }
}

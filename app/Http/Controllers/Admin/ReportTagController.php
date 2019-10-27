<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\ReportTagResource;
use App\Repositories\Contracts\ReportTagRepository;
use App\Http\Controllers\Controller;

class ReportTagController extends Controller
{
    protected $report_tags;

    public function __construct(ReportTagRepository $report_tags)
    {
        $this->report_tags = $report_tags;
    }

    public function tagify()
    {
        return ReportTagResource::collection(
            $this->report_tags->tagify()
        );
    }
}

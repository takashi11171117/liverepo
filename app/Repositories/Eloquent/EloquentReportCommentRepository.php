<?php

namespace App\Repositories\Eloquent;

use App\Models\ReportComment;
use App\Repositories\Contracts\ReportCommentRepository;
use App\Repositories\RepositoryAbstract;

class EloquentReportCommentRepository extends RepositoryAbstract implements ReportCommentRepository
{
    public function entity()
    {
        return ReportComment::class;
    }
}
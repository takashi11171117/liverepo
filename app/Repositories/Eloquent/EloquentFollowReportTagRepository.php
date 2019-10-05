<?php

namespace App\Repositories\Eloquent;

use App\Models\FollowReportTag;
use App\Models\ReportTag;
use App\Repositories\Contracts\FollowReportTagRepository;
use App\Repositories\RepositoryAbstract;

class EloquentFollowReportTagRepository extends RepositoryAbstract implements FollowReportTagRepository
{
    public function entity()
    {
        return FollowReportTag::class;
    }

    public function find(int $id): bool
    {
        return (boolean) (\Auth::user())->followReportTags()
                                        ->where('report_tag_id', $id)
                                        ->first(['id']);
    }

    public function detach(int $id): void
    {
        (\Auth::user())->followReportTags()->detach(
            (ReportTag::findOrFail($id))->id
        );
    }
}
<?php

namespace App\Repositories\Eloquent;

use App\Models\FollowReport;
use App\Models\User;
use App\Repositories\Contracts\FollowReportRepository;
use App\Repositories\RepositoryAbstract;

class EloquentFollowReportRepository extends RepositoryAbstract implements FollowReportRepository
{
    public function entity()
    {
        return FollowReport::class;
    }

    public function find(int $id): bool
    {
        return (boolean) (\Auth::user())->followReports()
                                        ->where('report_id', $id)
                                        ->first(['id']);
    }

    public function detach(int $id): void
    {
        (\Auth::user())->followReports()->detach(
            (User::findOrFail($id))->id
        );
    }
}
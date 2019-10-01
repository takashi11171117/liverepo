<?php

namespace App\Repositories\Eloquent;

use App\Models\Report;
use App\Repositories\Contracts\ReportRepository;
use App\Repositories\RepositoryAbstract;
use App\Scoping\Scopes\ByCreatedAtScope;

class EloquentReportRepository extends RepositoryAbstract implements ReportRepository
{
    public function entity()
    {
        return Report::class;
    }

    public function paginate(int $perPage = 10)
    {
        return $this->entity
            ->withScopes([
                'date' => new ByCreatedAtScope()
            ])
            ->with(['report_images'])
            ->orderBy('published_at', 'desc')
            ->status(config('const.PUBLISH'))
            ->paginate($perPage);
    }
}
<?php

namespace App\Repositories\Eloquent;

use App\Models\ReportTag;
use App\Repositories\Contracts\ReportTagRepository;
use App\Repositories\RepositoryAbstract;
use App\Scoping\Scopes\ReportTagSearchScope;

class EloquentReportTagRepository extends RepositoryAbstract implements ReportTagRepository
{
    public function entity()
    {
        return ReportTag::class;
    }

    public function tagify()
    {
        return $this->entity->withScopes([
            'tag' => new ReportTagSearchScope()
        ])->limit(10)->get();
    }
}
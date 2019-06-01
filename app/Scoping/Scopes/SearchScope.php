<?php

namespace App\Scoping\Scopes;

use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;

class ReportSearchScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        return $builder->where('title','like',"%$value%", 'or')
            ->where('content','like',"%$value%", 'or');
    }
}
<?php

namespace App\Scoping\Scopes;

use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;

class ReportTagSearchScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        return $builder->where('name','like',"%$value%", 'or');
    }
}
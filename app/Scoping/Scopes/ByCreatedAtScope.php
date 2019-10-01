<?php

namespace App\Scoping\Scopes;

use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;

class ByCreatedAtScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        return $builder->where('created_at','like',"%$value%");
    }
}
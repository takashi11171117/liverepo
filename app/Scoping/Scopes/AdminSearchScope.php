<?php

namespace App\Scoping\Scopes;

use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;

class AdminSearchScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        return $builder->where('name','like',"%$value%", 'or')
            ->where('email','like',"%$value%", 'or');
    }
}
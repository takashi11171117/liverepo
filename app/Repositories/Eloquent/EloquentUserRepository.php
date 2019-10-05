<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\RepositoryAbstract;

class EloquentUserRepository extends RepositoryAbstract implements UserRepository
{
    public function entity()
    {
        return User::class;
    }
}
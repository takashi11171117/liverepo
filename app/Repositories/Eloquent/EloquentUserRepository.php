<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\RepositoryAbstract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentUserRepository extends RepositoryAbstract implements UserRepository
{
    public function entity()
    {
        return User::class;
    }

    public function findWhereFirst(string $column, string $value)
    {
        $model = $this->entity
            ->with(['followUsers', 'followers', 'followReportTags'])
            ->where($column, $value)->first();

        if (!$model) {
            throw (new ModelNotFoundException())->setModel(
                get_class($this->entity->getModel())
            );
        }

        return $model;
    }
}
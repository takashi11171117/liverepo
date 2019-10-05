<?php

namespace App\Repositories\Eloquent;

use App\Models\FollowUser;
use App\Models\User;
use App\Repositories\Contracts\FollowUserRepository;
use App\Repositories\RepositoryAbstract;

class EloquentFollowUserRepository extends RepositoryAbstract implements FollowUserRepository
{
    public function entity()
    {
        return FollowUser::class;
    }

    public function find(int $id): bool
    {
        return (boolean) (\Auth::user())->followUsers()
                                        ->where('followed_user_id', $id)
                                        ->first(['id']);
    }

    public function detach(int $id): void
    {
        (\Auth::user())->followUsers()->detach(
            (User::findOrFail($id))->id
        );
    }
}
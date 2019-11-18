<?php

namespace App\Repositories\Eloquent;

use App\Models\SocialAccount;
use App\Repositories\Contracts\SocialAccountRepository;
use App\Repositories\RepositoryAbstract;

class EloquentSocialAccountRepository extends RepositoryAbstract implements SocialAccountRepository
{
    public function entity()
    {
        return SocialAccount::class;
    }
}
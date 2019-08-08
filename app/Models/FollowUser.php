<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FollowUser extends Pivot
{
    protected $table = 'follow_users';
    public $timestamps = false;
    protected $guarded = [];
}

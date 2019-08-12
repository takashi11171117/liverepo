<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FollowReport extends Pivot
{
    protected $table = 'follow_reports';
    public $timestamps = false;
    protected $guarded = [];
}
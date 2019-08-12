<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FollowReportTag extends Pivot
{
    protected $table = 'follow_report_tags';
    public $timestamps = false;
    protected $guarded = [];
}
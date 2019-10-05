<?php

namespace App\Models;

use App\Models\Traits\CanBeScoped;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportTag extends Model
{
    use CanBeScoped, SoftDeletes;

    protected $fillable = [
        'name', 'taxonomy',
    ];

    protected $dates = ['deleted_at'];

    public function reports()
    {
        return $this->belongsToMany(Report::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follow_report_tags', 'report_tag_id', 'user_id')
                    ->using(FollowReportTag::class);
    }
}

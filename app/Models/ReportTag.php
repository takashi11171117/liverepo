<?php

namespace App\Models;

use App\Models\Traits\CanBeScoped;
use Illuminate\Database\Eloquent\Model;

class ReportTag extends Model
{
    use CanBeScoped;

    protected $fillable = [
        'name', 'taxonomy',
    ];

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

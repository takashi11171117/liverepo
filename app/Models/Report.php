<?php

namespace App\Models;

use App\Models\Traits\CanBeScoped;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use CanBeScoped;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'status', 'rating',
    ];

    public function scopeStatus(Builder $builder, $value)
    {
        $builder->where('status', $value);
    }

    public function report_images()
    {
        return $this->hasMany(ReportImage::class, 'report_id', 'id');
    }

    public function report_tags()
    {
        return $this->belongsToMany(ReportTag::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follow_reports', 'report_id', 'user_id')
                    ->using(FollowReport::class);
    }
}

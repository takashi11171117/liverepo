<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'status', 'rating',
    ];

    public function scopePublish(Builder $builder)
    {
        $builder->where('status', 1);
    }

    public function scopeDraft(Builder $builder)
    {
        $builder->where('status', 0);
    }

    public function scopeTrash(Builder $builder)
    {
        $builder->where('status', 2);
    }

    public function report_images()
    {
        return $this->hasMany('App\Models\ReportImage', 'report_id', 'id');
    }

    public function report_tags()
    {
        return $this->belongsToMany('App\Models\ReportTag');
    }
}

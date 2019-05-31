<?php

namespace App\Models;

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

    public function report_images()
    {
        return $this->hasMany('App\Models\ReportImage', 'report_id', 'id');
    }

    public function report_tags()
    {
        return $this->belongsToMany('App\Models\ReportTag');
    }
}

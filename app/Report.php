<?php

namespace App;

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
        return $this->hasMany('App\ReportImage', 'report_id', 'id');
    }
}

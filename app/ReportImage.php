<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportImage extends Model
{
    protected $fillable = ['report_id', 'path'];

    public function report()
    {
        return $this->belongsTo('App\Report');
    }
}

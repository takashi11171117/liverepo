<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportImage extends Model
{
    protected $fillable = ['report_id', 'path'];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}

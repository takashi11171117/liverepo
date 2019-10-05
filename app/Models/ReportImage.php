<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportImage extends Model
{
    use SoftDeletes;

    protected $fillable = ['report_id', 'path'];

    protected $dates = ['deleted_at'];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportComment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'body', 'report_id', 'user_id'
    ];

    protected $dates = ['deleted_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function report() {
        return $this->belongsTo(Report::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportComment extends Model
{
    protected $fillable = [
        'body', 'report_id', 'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function report() {
        return $this->belongsTo(Report::class);
    }
}

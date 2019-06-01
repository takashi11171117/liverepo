<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportTag extends Model
{
    protected $fillable = [
        'name', 'taxonomy',
    ];

    public function reports()
    {
        return $this->belongsToMany(Report::class);
    }
}

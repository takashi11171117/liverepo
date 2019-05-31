<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportTag extends Model
{
    protected $fillable = [
        'name', 'taxonomy',
    ];
}

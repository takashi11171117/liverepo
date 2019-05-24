<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportTag extends Model
{
    protected $fillable = [
        'name', 'taxonomy',
    ];
}

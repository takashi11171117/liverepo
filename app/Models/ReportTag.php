<?php

namespace App\Models;

use App\Models\Traits\CanBeScoped;
use Illuminate\Database\Eloquent\Model;

class ReportTag extends Model
{
    use CanBeScoped;

    protected $fillable = [
        'name', 'taxonomy',
    ];

    public function reports()
    {
        return $this->belongsToMany(Report::class);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\ReportImageResourse;
use App\Repositories\Contracts\ReportImageRepository;
use App\Http\Controllers\Controller;

class ReportImageController extends Controller
{
    protected $report_tags;

    public function __construct(ReportImageRepository $report_images)
    {
        $this->report_images = $report_images;
    }

    public function findByName(string $name)
    {
        $report_image = $this->report_images->findByName($name);

        return new ReportImageResourse($report_image);
    }
}

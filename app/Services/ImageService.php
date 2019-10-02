<?php

namespace App\Services;

use App\Models\Report;

class ImageService
{
    public function createReportImage(Report $report, $image): string
    {
        $disk = \Storage::disk('s3');

        $file      = $image;
        $extension = $image->getClientOriginalExtension();
        $filename  = "{$report->id}_01.$extension";

        $image_data = \Image::make($file)
                       ->resize(1024, null, function ($constraint) {
                           $constraint->aspectRatio();
                       });
        $disk->put('report_images/' . $filename, (string)$image_data->encode());

        $image_data = \Image::make($file)
                       ->fit(300, 300);
        $disk->put('report_images/thumb-' . $filename, (string)$image_data->encode());

        return $filename;
    }
}
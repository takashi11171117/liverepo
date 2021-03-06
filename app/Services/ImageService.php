<?php

namespace App\Services;

use App\Models\Report;

class ImageService
{
    public function createReportImage(string $tmpFilename, $image): string
    {
        $disk = \Storage::disk('s3');

        $filename  = $this->createFileName($tmpFilename, $image);

        $image_data = \Image::make($image)
                       ->resize(1024, null, function ($constraint) {
                           $constraint->aspectRatio();
                       });
        $disk->put('report_images/' . $filename, (string)$image_data->encode());

        $image_data = \Image::make($image)
                       ->fit(300, 300);
        $disk->put('report_images/thumb-' . $filename, (string)$image_data->encode());

        return $filename;
    }

    private function createFileName(string $tmpFilename, $image): string
    {
        $extension = $image->getClientOriginalExtension();
        return "$tmpFilename.$extension";
    }

    public function createUserImage($image): string
    {
        $disk = \Storage::disk('s3');

        $extension = $image->getClientOriginalExtension();
        $filename  = \Auth::id() . "_icon.$extension";

        $image_data = \Image::make($image)
                       ->fit(500, 500);
        $disk->put('profile_images/' . $filename, (string)$image_data->encode());

        $image_data = \Image::make($image)
                       ->fit(100, 100);
        $disk->put('profile_images/thumb-' . $filename, (string)$image_data->encode());

        return $filename;
    }
}
<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportImageResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'src' => config('const.IMAGE_URL') . 'report_images/' . $this->path,
            'thumb' => config('const.IMAGE_URL') . 'report_images/thumb-' . $this->path
        ];
    }
}

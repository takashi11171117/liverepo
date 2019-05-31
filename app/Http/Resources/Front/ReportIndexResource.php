<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportIndexResource extends JsonResource
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
            'title' => $this->title,
            'rating' => $this->rating,
            'content' => $this->content,
            'report_images' => ReportImageIndexResource::collection($this->whenLoaded('report_images'))
        ];
    }
}

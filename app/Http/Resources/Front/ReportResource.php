<?php

namespace App\Http\Resources\Front;

use App\Http\Resources\Front\Re;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'title' => $this->title,
            'rating' => $this->rating,
            'content' => $this->content,
        ];

        $report_tags = ReportTagResource::collection($this->report_tags);
        if (!$report_tags->isEmpty()) {
            $result['report_tags'] = $report_tags;
        }

        $report_images = ReportImageResourse::collection($this->report_images);
        if (!$report_images->isEmpty()) {
            $result['report_images'] = $report_images;
        }

        $result['user'] = new UserResource($this->user);

        return $result;
    }
}

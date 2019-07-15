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
        $result = [
            'id' => $this->id,
            'title' => $this->title,
            'rating' => $this->rating,
            'content' => $this->content,
        ];

        $report_images = ReportImageIndexResource::collection($this->report_images);
        if (!$report_images->isEmpty()) {
            $result['report_images'] = $report_images;
        }

        $result['user'] = new UserResource($this->user);

        return $result;
    }
}

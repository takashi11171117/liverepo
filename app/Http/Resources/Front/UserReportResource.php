<?php

namespace App\Http\Resources\Front;

use App\Http\Resources\Admin\ReportTagResource;
use App\Http\Resources\Admin\ReportImageResourse;
use Illuminate\Http\Resources\Json\JsonResource;

class UserReportResource extends JsonResource
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
            'status' => $this->status,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        $report_tags = ReportTagResource::collection($this->report_tags);
        if (!$report_tags->isEmpty()) {
            $result['report_tags'] = $report_tags;
        }

        $report_images = ReportImageResourse::collection($this->report_images);
        if (!$report_images->isEmpty()) {
            $result['report_images'] = $report_images;
        }

        return $result;
    }
}

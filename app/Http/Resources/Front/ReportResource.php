<?php

namespace App\Http\Resources\Front;

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
            'followers_count' => $this->followers_count,
        ];

        $report_tags = ReportTagIndexResource::collection($this->report_tags);
        if (!$report_tags->isEmpty()) {
            $result['report_tags'] = $report_tags;
        }

        $report_images = ReportImageResourse::collection($this->report_images);
        if (!$report_images->isEmpty()) {
            $result['report_images'] = $report_images;
        }

        $report_comments = ReportCommentResource::collection($this->report_comments);
        if (!$report_comments->isEmpty()) {
            $result['report_comments'] = $report_comments;
        }

        $result['user'] = new UserResource($this->user);

        return $result;
    }
}

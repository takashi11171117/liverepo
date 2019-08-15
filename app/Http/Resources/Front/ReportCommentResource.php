<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result =  [
            'body' => $this->body,
            'created_at' => $this->created_at->format('Y-m-d h:i:s')
        ];

        $result['user'] = new UserResource($this->user);

        return $result;
    }
}

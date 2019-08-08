<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class FollowUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $args = [
            'name'   => $this->name,
        ];

        if ($this->image_path !== null) {
            $args['thumb'] = config('const.IMAGE_URL') . 'profile_images/thumb-' . $this->image_path;
        }

        return $args;
    }
}

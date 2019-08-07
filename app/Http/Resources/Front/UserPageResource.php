<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class UserPageResource extends JsonResource
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
            'id'     => $this->id,
            'name'   => $this->name,
            'gender' => $this->gender,
            'birth'  => $this->birth,
            'pref'  => $this->pref,
        ];

        if ($this->image_path !== null) {
            $args['src'] = config('const.IMAGE_URL') . 'profile_images/' . $this->image_path;
        }

        if ($this->image_path !== null) {
            $args['thumb'] = config('const.IMAGE_URL') . 'profile_images/thumb-' . $this->image_path;
        }

        return $args;
    }
}

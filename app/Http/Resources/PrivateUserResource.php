<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrivateUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $args = [
            'id'     => $this->id,
            'email' => $this->email,
            'name'   => $this->name,
            'gender' => $this->gender,
            'birth'  => $this->birth,
            'description'  => $this->description,
            'url'  => $this->url,
            'user_name01' => $this->user_name01,
            'user_name02' => $this->user_name02,
        ];

        if ($this->mail_send_flg) {
            $args['email'] = $this->email;
        }

        if ($this->image_path !== null) {
            $args['src'] = config('const.IMAGE_URL') . 'profile_images/' . $this->image_path;
        }

        if ($this->image_path !== null) {
            $args['thumb'] = config('const.IMAGE_URL') . 'profile_images/thumb-' . $this->image_path;
        }

        return $args;
    }
}

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
        $array = [
            'id'     => $this->id,
            'name'   => $this->name,
            'gender' => $this->gender,
            'birth'  => $this->birth,
            'pref'  => $this->pref,
            'user_name01'   => $this->user_name01,
            'user_name02'   => $this->user_name02,
            'description'   => $this->description,
            'url'           => $this->url,
            'show_mail_flg' => $this->show_mail_flg,
        ];

        if ($this->image_path !== null) {
            $array['src'] = config('const.IMAGE_URL') . 'profile_images/' . $this->image_path;
            $array['thumb'] = config('const.IMAGE_URL') . 'profile_images/thumb-' . $this->image_path;
        }

        if ($this->followUsers !== null) {
            $array['follow_users'] = FollowUserResource::collection($this->followUsers);
        }

        if ($this->followers !== null) {
            $array['followers'] = FollowerResource::collection($this->followers);
        }

        if ($this->followReportTags !== null) {
            $array['follow_report_tags'] = ReportTagIndexResource::collection($this->followReportTags);
        }

        return $array;
    }
}

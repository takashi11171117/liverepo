<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\User\Profile\Post as ProfilePost;
use App\Models\User;
use App\Repositories\Contracts\ReportRepository;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Storage;

class SettingController extends Controller
{
    protected $reports;

    protected $image_service;

    public function __construct(ReportRepository $reports, ImageService $image_service)
    {
        $this->reports       = $reports;
        $this->image_service = $image_service;
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function profile(ProfilePost $request)
    {
        $user_id = $request->get('user_id');
        $user    = User::find($user_id);

        $args = $request->only([
            'user_name01',
            'user_name02',
            'show_mail_flg',
            'url',
            'description',
            'gender',
            'birth',
        ]);

        $file = $request->file('image');

        if ($file !== null) {
            // 画像の登録
            $disk = Storage::disk('s3');

            $extension = $file->getClientOriginalExtension();
            $filename  = "{$user_id}_icon.$extension";

            $image = \Image::make($file)
                           ->fit(500, 500);
            $disk->put('profile_images/' . $filename, (string)$image->encode());

            $image = \Image::make($file)
                           ->fit(100, 100);
            $disk->put('profile_images/thumb-' . $filename, (string)$image->encode());

            $args['image_path'] = $filename;
        }

        $user->update($args);
    }
}

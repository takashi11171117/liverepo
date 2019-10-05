<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\UserPageResource;
use App\Http\Requests\Front\User\Profile\Post as ProfilePost;
use App\Repositories\Contracts\UserRepository;
use App\Services\ImageService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $users;

    protected $image_service;

    public function __construct(UserRepository $users, ImageService $image_service)
    {
        $this->users       = $users;
        $this->image_service = $image_service;
    }

    public function show(string $name)
    {
        return new UserPageResource(
            $this->users->findWhereFirst('name', $name)
        );
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function profile(ProfilePost $request)
    {
        $params = $request->only([
            'user_name01',
            'user_name02',
            'show_mail_flg',
            'url',
            'description',
            'gender',
            'birth',
        ]);

        if (($image = $request->file('image')) !== null) {
            $params['image_path'] = $this->image_service->createUserImage($image);
        }

        $this->users->update(\Auth::id(), $params);
    }
}

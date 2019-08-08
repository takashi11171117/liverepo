<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\FollowUserResource;
use App\Http\Resources\Front\FollowerResource;
use App\Http\Resources\Front\UserPageResource;
use App\Http\Resources\Front\UserReportIndexResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, $name)
    {
        $user = (User::with(['followUsers', 'followers'])->where('name', $name)->get())[0];

        $reports = $user->reports()->paginate(10);

        return [
            'user' => new UserPageResource($user),
            'reports' => UserReportIndexResource::collection($reports),
        ];
    }
}

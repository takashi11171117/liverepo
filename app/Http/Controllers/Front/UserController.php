<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\UserPageResource;
use App\Http\Resources\Front\UserReportIndexResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, $name)
    {
        $user = User::where('name', $name)->get();

        $reports = $user[0]->reports()->paginate(10);

        return [
            'user' => new UserPageResource($user[0]),
            'reports' => UserReportIndexResource::collection($reports),
        ];
    }
}

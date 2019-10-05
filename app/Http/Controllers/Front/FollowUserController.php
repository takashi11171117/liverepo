<?php

namespace App\Http\Controllers\Front;

use App\Repositories\Contracts\FollowUserRepository;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FollowUserController extends Controller
{
    protected $follow_users, $users;

    public function __construct(FollowUserRepository $follow_users, UserRepository $users)
    {
        $this->follow_users = $follow_users;
        $this->users = $users;
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(
            ['result' => $this->follow_users->find($id)]
        );
    }

    public function store(Request $request): void
    {
        $params = [
            'user_id' => \Auth::id(),
            'followed_user_id' => ($this->users->find(
                (int) $request->input('id') ?? 0
            ))->id
        ];

        $this->follow_users->create($params);
    }

    public function destroy(int $id): void
    {
        $this->follow_users->detach($id);
    }
}

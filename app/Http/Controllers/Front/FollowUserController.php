<?php

namespace App\Http\Controllers\Front;

use App\Models\FollowUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FollowUserController extends Controller
{
    public function store(Request $request)
    {
        $followedUser = User::findOrFail($request->input('id'));
        FollowUser::firstOrCreate([
            'user_id' => \Auth::id(),
            'followed_user_id' => $followedUser->id,
        ]);
        return response()->json(['result' => true]);
    }

    public function destroy($id)
    {
        $followedUser = User::findOrFail($id);
        $user = \Auth::user();
        $user->followUsers()->detach($followedUser->id);
        return response()->json(['result' => true]);
    }

    public function isFollowing($id)
    {
        $user = \Auth::user();
        $follow = $user->followUsers()->where('followed_user_id', $id)->first(['id']);
        return response()->json(['result' => (boolean) $follow]);
    }
}

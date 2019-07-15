<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Requests\Auth\User\RegisterRequest;
use App\Http\Resources\PrivateUserResource;
use App\Models\User;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function action(RegisterRequest $request) {
        $user = User::create(
            $request->only(
                'name', 'email', 'password', 'gender', 'birth'
            )
        );

        return new PrivateUserResource($user);
    }
}

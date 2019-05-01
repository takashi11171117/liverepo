<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthAdminController extends Controller
{
    public function login() {
        $credentials = request(['email', 'password']);

        if (! $token = auth("admins")->attempt($credentials)) {
            return response()->json(['error' => 'メールアドレスかパスワードが一致しません'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth("admins")->factory()->getTTL() * 60
        ]);
    }
}

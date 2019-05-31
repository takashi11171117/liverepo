<?php

namespace App\Http\Controllers;

use App\Models\Admin;

class AuthAdminController extends Controller
{
    public function login() {
        $credentials = request(['email', 'password']);

        if (! $token = auth("admins")->attempt($credentials)) {
            return response()->json(['error' => 'メールアドレスかパスワードが一致しません'], 401);
        }

        return $this->respondWithToken($token, $credentials);
    }

    protected function respondWithToken($token, $credentials)
    {
        $admin = Admin::where('email', $credentials['email'])->first();
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth("admins")->factory()->getTTL() * 60,
            'admin' => $admin
        ]);
    }
}

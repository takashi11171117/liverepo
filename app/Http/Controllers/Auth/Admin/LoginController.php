<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Admin\LoginRequest;
use App\Models\Admin;

class LoginController extends Controller
{
    public function action(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if (!$token = auth("admins")->attempt($credentials)) {
            return response()->json([
                'errors' => [
                    'email' => ['メールアドレスかパスワードが一致しません']
                ]
            ], 422);
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

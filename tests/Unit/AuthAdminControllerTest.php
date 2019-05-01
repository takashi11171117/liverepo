<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AuthAdminControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function testError()
    {
        factory('App\Admin')->create();

        $params = [
            'email' => 'a',
            'password' => 'pass'
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            "Authorization" => "Bearer",
        ];

        $this->json(
            'POST',
            '/auth/admin',
            $params,
            $headers
        )->assertStatus(401)
        ->assertJson(
            ['error' => 'メールアドレスかパスワードが一致しません']
        );
    }

    public function testSuccess()
    {
        $admin = factory('App\Admin')->create();

        $params = [
            'email'    => $admin->email,
            'password' => 'pass'
        ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $this->json(
            'POST',
            '/auth/admin',
            $params,
            $headers
        )->assertStatus(200)
         ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }
}

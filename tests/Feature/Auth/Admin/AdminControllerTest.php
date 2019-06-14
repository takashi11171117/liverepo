<?php

namespace Tests\Feature\Auth\Admin;

use App\Models\Admin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AdminControllerTest extends TestCase
{
    public function testError()
    {
        factory('App\Models\Admin')->create();

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
        )->assertStatus(422)
        ->assertJson(
            ['errors' =>
                 [
                     'email' => ['メールアドレスかパスワードが一致しません']
                 ]
            ]
        );
    }

    public function testSuccess()
    {
        $admin = factory(Admin::class)->create();

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
         ->assertJsonStructure(['token', 'token_type', 'expires_in', 'admin']);
    }
}

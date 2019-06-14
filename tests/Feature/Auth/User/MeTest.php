<?php

namespace Tests\Feature\Auth\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeTest extends TestCase
{
    public function test_it_fails_if_user_isnt_authenticated()
    {
        $this->json('GET', 'auth/me')
             ->assertStatus(401);
    }

    public function test_it_returns_user_details()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'GET', 'auth/me')
             ->assertJsonFragment([
                 'email' => $user->email
             ]);
    }
}

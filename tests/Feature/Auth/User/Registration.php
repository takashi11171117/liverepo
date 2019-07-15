<?php

namespace Tests\Feature\Auth\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_it_requires_a_name()
    {
        $this->json('POST', 'auth/register')
             ->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_a_email()
    {
        $this->json('POST', 'auth/register')
             ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_valid_email()
    {
        $this->json('POST', 'auth/register', [
            'email' => 'nope'
        ])
             ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_unique_email()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'auth/register', [
            'email' => $user->email
        ])
             ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password()
    {
        $this->json('POST', 'auth/register')
             ->assertJsonValidationErrors(['password']);
    }

    public function test_it_requires_a_gender()
    {
        $this->json('POST', 'auth/register')
             ->assertJsonValidationErrors(['gender']);
    }

    public function test_it_requires_a_birth()
    {
        $this->json('POST', 'auth/register')
             ->assertJsonValidationErrors(['birth']);
    }

    public function test_it_registers_a_user()
    {
        $this->json('POST', 'auth/register', [
            'name' => $name = 'Alex',
            'email' => $email = 'alex@codecourse.com',
            'password' => 'secret'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => $name
        ]);
    }

    public function test_it_returns_a_user_on_registration()
    {
        $this->json('POST', 'auth/register', [
            'name' => 'Alex',
            'email' => $email = 'alex@codecourse.com',
            'password' => 'secret',
            'gender' => 1,
            'birth' => (new \DateTime())->format('Y/m/d m:d:s'),
        ])
             ->assertJsonFragment([
                 'email' => $email
             ]);
    }
}

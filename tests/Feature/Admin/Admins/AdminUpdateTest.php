<?php

namespace Tests\Feature\Admin\Admins;

use App\Models\Admin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminUpdateTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $response = $this->json('PUT', 'admin/admins/1')
            ->assertStatus(401);
    }

    public function test_it_fails_if_a_admin_cant_be_found()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', "admin/admins/100", [
            'name' => 'test',
            'email' => 'mail@gmail.com',
        ])
             ->assertStatus(404);
    }

    public function test_it_requires_a_name()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', 'admin/admins/1')
             ->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_a_email()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', 'admin/admins/1')
             ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_collect_email()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', 'admin/admins/1', [
            'name' => 'test_content',
            'email' => 'test',
            'password'  => '3387Ezweb',
        ])
             ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password_over_8_word()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', 'admin/admins/1', [
            'name' => 'test_content',
            'email' => 'test@gmail.com',
            'password'  => '3387E',
        ])
             ->assertJsonValidationErrors(['password']);
    }

    public function test_it_requires_a_password_into_big_word()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', 'admin/admins/1', [
            'name' => 'test_content',
            'email' => 'test@gmail.com',
            'password'  => '3387ezweb',
        ])
             ->assertJsonValidationErrors(['password']);
    }

    public function test_it_requires_a_password_into_number_and_word()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', 'admin/admins/1', [
            'name' => 'test_content',
            'email' => 'test@gmail.com',
            'password'  => 'webEzweb',
        ])
             ->assertJsonValidationErrors(['password']);
    }

    public function test_it_can_create_an_admin()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', 'admin/admins/1', [
            'name' => 'test_content',
            'email' => 'test@gmail.com',
            'password'  => '3387Ezweb',
            'password_confirmation' => '3387Ezweb',
        ]);

        $admin = Admin::find(1);

        $this->assertDatabaseHas('admins', [
            'name' => 'test_content',
            'email' => 'test@gmail.com',
            'password' => $admin->password,
        ]);
    }
}

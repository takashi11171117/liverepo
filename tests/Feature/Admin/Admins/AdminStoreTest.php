<?php

namespace Tests\Feature\Admin\Admins;

use App\Models\Admin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminStoreTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $response = $this->json('POST', 'admin/admin/add')
            ->assertStatus(401);
    }

    public function test_it_requires_a_name()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/admin/add')
             ->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_a_email()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/admin/add')
             ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/admin/add')
             ->assertJsonValidationErrors(['password']);
    }

    public function test_it_requires_a_collect_email()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/admin/add', [
            'name' => 'test_content',
            'email' => 'test',
            'password'  => '3387Ezweb',
        ])
             ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password_over_8_word()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/admin/add', [
            'name' => 'test_content',
            'email' => 'test@gmail.com',
            'password'  => '3387E',
        ])
             ->assertJsonValidationErrors(['password']);
    }

    public function test_it_requires_a_password_into_big_word()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/admin/add', [
            'name' => 'test_content',
            'email' => 'test@gmail.com',
            'password'  => '3387ezweb',
        ])
             ->assertJsonValidationErrors(['password']);
    }

    public function test_it_requires_a_password_into_number_and_word()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/admin/add', [
            'name' => 'test_content',
            'email' => 'test@gmail.com',
            'password'  => 'webEzweb',
        ])
             ->assertJsonValidationErrors(['password']);
    }

    public function test_it_can_create_an_admin()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/admin/add', [
            'name' => 'test_content',
            'email' => 'test@gmail.com',
            'password'  => '3387Ezweb',
            'password_confirmation' => '3387Ezweb',
        ]);

        $admin = Admin::find(2);

        $this->assertDatabaseHas('admins', [
            'name' => 'test_content',
            'email' => 'test@gmail.com',
            'password' => $admin->password,
        ]);
    }
}

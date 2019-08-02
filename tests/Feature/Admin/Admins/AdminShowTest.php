<?php

namespace Tests\Feature\Admin\Admins;

use App\Models\Admin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminShowTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $response = $this->json('GET', "admin/admins/1")
                         ->assertStatus(401);
    }

    public function test_it_fails_if_a_admin_cant_be_found()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'GET', "admin/reports/100")
             ->assertStatus(404);
    }

    public function test_it_shows_a_admin()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'GET', "admin/admins/{$admin->id}")
             ->assertJsonFragment([
                 'id' => $admin->id
             ]);
    }
}

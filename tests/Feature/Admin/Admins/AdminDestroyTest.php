<?php

namespace Tests\Feature\Admin\Admins;

use App\Models\Admin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDestroyTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $response = $this->json('DELETE', 'admin/admin/1/delete')
                         ->assertStatus(401);
    }

    public function test_it_fails_if_admin_cant_be_found()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->jsonAsAdmin($admin, 'DELETE', 'admin/admin/10/delete')
                         ->assertStatus(404);
    }

    public function test_it_deletes_a_report()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->jsonAsAdmin($admin, 'DELETE', "admin/admin/{$admin->id}/delete");

        $this->assertDatabaseMissing('admins', [
            'id' => $admin->id
        ]);
    }
}

<?php

namespace Tests\Feature\Admin\Admins;

use App\Models\Admin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminIndexTest extends TestCase
{
    public function test_it_fails_if_admin_isnt_authenticated()
    {
        $this->json('GET', 'admin/admin')
             ->assertStatus(401);
    }

    public function test_it_returns_a_collection()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->jsonAsAdmin($admin, 'GET', 'admin/admin');

        $response->assertJsonFragment([
            'name' => $admin->name,
        ]);
    }

    public function test_it_has_paginated_data() {
        $admin = factory(Admin::class)->create();

        $response = $this->jsonAsAdmin($admin, 'GET', 'admin/admin')
                         ->assertJsonStructure([
                             'meta'
                         ]);
    }
}

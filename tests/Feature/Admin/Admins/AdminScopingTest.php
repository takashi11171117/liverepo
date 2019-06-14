<?php

namespace Tests\Feature\Admin\Admins;

use App\Models\Admin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminScopingTest extends TestCase
{
    public function test_it_can_scope_by_name()
    {
        $admin = factory(Admin::class)->create([
            'name' => 'testtest'
        ]);

        $anotherAdmin = factory(Admin::class)->create();

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'GET', "admin/admin?s=testtest")
             ->assertJsonCount(1, 'data');
    }

    public function test_it_can_scope_by_email()
    {
        $admin = factory(Admin::class)->create([
            'email' => 'test@zatzatzat.com'
        ]);

        $anotherAdmin = factory(Admin::class)->create();

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'GET', "admin/admin?s=zatzatzat")
             ->assertJsonCount(1, 'data');
    }
}

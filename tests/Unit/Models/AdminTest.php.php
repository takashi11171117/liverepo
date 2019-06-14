<?php

namespace Tests\Unit\Models;

use App\Models\Admin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    public function test_it_hashes_the_password_when_creating()
    {
        $user = factory(Admin::class)->create([
            'password' => 'cats'
        ]);

        $this->assertNotEquals($user->password, 'cats');
    }
}

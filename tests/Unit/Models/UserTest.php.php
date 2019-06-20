<?php

namespace Tests\Unit\Models;

use App\Models\Report;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function test_it_hashes_the_password_when_creating()
    {
        $user = factory(User::class)->create([
            'password' => 'cats'
        ]);

        $this->assertNotEquals($user->password, 'cats');
    }

    public function  test_it_has_many_reports()
    {
        $user = factory(User::class)->create();

        $user->reports()->save(
            factory(Report::class)->create()
        );

        $this->assertInstanceOf(Report::class, $user->reports()->first());

    }
}

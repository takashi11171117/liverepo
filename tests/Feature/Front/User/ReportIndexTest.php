<?php

namespace Tests\Feature\Front\User;

use App\Models\Report;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportIndexTest extends TestCase
{
    public function test_it_fails_if_user_isnt_authenticated()
    {
        $this->json('GET', 'setting/report/1')
             ->assertStatus(401);
    }

    public function test_it_returns_a_collection()
    {
        $user = factory(User::class)->create();

        $report = factory(Report::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->jsonAsUser($user, 'GET', "setting/report/{$report->id}");

        $response->assertJsonFragment([
            'title' => $report->title,
        ]);
    }

    public function test_it_has_paginated_data() {
        $user = factory(User::class)->create();

        $response = $this->jsonAsUser($user, 'GET', 'setting/report/1')
                         ->assertJsonStructure([
                             'meta'
                         ]);
    }
}

<?php

namespace Tests\Feature\Front\Reports;

use App\Models\Report;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportIndexTest extends TestCase
{
    public function test_it_returns_a_scoped_collection()
    {
        $report = factory(Report::class)->create([
            'status' => 1
        ]);

        $response = $this->json('GET', '/');

        $response->assertJsonFragment([
            'title' => $report->title,
        ])->assertJsonCount(1, 'data');
    }

    public function test_it_has_paginated_data() {
        $response = $this->json('GET', '/')
                         ->assertJsonStructure([
                             'meta'
                         ]);
    }
}

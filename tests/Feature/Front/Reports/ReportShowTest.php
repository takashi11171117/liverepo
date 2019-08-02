<?php

namespace Tests\Feature\Front\Reports;

use App\Models\Admin;
use App\Models\Report;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportShowTest extends TestCase
{
    public function test_it_fails_if_a_report_cant_be_found()
    {
        $this->json('GET', "comedy/reports/100")
             ->assertStatus(404);
    }

    public function test_it_shows_a_product()
    {
        $report = factory(Report::class)->create();

        $this->json('GET', "comedy/reports/{$report->id}")
             ->assertJsonFragment([
                 'id' => $report->id
             ]);
    }
}

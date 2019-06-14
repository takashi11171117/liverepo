<?php

namespace Tests\Feature\Admin\Reports;

use App\Models\Admin;
use App\Models\Report;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportsShowTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $report = factory(Report::class)->create();

        $response = $this->json('GET', "admin/report/{$report->id}")
                         ->assertStatus(401);
    }

    public function test_it_fails_if_a_report_cant_be_found()
    {
        $report = factory(Report::class)->create();

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'GET', "admin/report/100")
             ->assertStatus(404);
    }

    public function test_it_shows_a_product()
    {
        $report = factory(Report::class)->create();

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'GET', "admin/report/{$report->id}")
             ->assertJsonFragment([
                 'id' => $report->id
             ]);
    }
}

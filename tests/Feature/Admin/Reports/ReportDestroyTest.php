<?php

namespace Tests\Feature\Admin\Reports;

use App\Models\Admin;
use App\Models\Report;
use App\Models\ReportImage;
use App\Models\ReportTag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportDestroyTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $response = $this->json('DELETE', 'admin/report/1/delete')
                         ->assertStatus(401);
    }

    public function test_it_fails_if_report_cant_be_found()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->jsonAsAdmin($admin, 'DELETE', 'admin/report/1/delete')
                         ->assertStatus(404);
    }

    public function test_it_deletes_a_report()
    {
        $reports = factory(Report::class, 1)
            ->create()
            ->each(function(Report $report) {
                $report->report_tags()->saveMany(factory(ReportTag::class, rand(0, 3))->make());
                $report->report_images()->saveMany(factory(ReportImage::class, 1)->make());
            });

        $admin = factory(Admin::class)->create();

        $response = $this->jsonAsAdmin($admin, 'DELETE', "admin/report/{$reports[0]->id}/delete");

        $this->assertDatabaseMissing('reports', [
                'id' => $reports[0]->id
            ]);
    }
}

<?php

namespace Tests\Feature\Admin\Reports;

use App\Models\Admin;
use App\Models\Report;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportScopingTest extends TestCase
{
    public function test_it_can_scope_by_title()
    {
        $report = factory(Report::class)->create([
            'title' => 'testtest'
        ]);

        $anotherReport = factory(Report::class)->create();

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'GET', "admin/reports?s=testtest")
             ->assertJsonCount(1, 'data');
    }

    public function test_it_can_scope_by_content()
    {
        $report = factory(Report::class)->create([
            'content' => 'test@zatzatzat.com'
        ]);

        $anotherReport = factory(Report::class)->create();

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'GET', "admin/reports?s=zatzatzat")
             ->assertJsonCount(1, 'data');
    }
}

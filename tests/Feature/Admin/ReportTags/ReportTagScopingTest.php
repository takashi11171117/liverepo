<?php

namespace Tests\Feature\Admin\ReportTags;

use App\Models\Admin;
use App\Models\ReportTag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTagScopingTest extends TestCase
{
    public function test_it_can_scope_by_name()
    {
        $reportTag = factory(ReportTag::class)->create([
            'name' => 'test'
        ]);

        $reportTagAnother = factory(ReportTag::class)->create();

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'GET', "admin/report_tag/tagify?tag=tes")
             ->assertJsonCount(1, 'data');
    }
}

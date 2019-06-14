<?php

namespace Tests\Feature\Admin\ReportTags;

use App\Models\Admin;
use App\Models\ReportTag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTagTagifyTest extends TestCase
{
    public function test_it_fails_if_admin_isnt_authenticated()
    {
        $this->json('GET', 'admin/report_tag/tagify')
             ->assertStatus(401);
    }

    public function test_it_returns_a_collection()
    {
        $report_tag = factory(ReportTag::class)->create();

        $admin = factory(Admin::class)->create();

        $response = $this->jsonAsAdmin($admin, 'GET', 'admin/report_tag/tagify');

        $response->assertJsonFragment([
            'data' => [$report_tag->name],
        ]);
    }
}

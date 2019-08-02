<?php

namespace Tests\Feature\Admin\Reports;

use App\Models\Admin;
use App\Models\Report;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportIndexTest extends TestCase
{
    public function test_it_fails_if_user_isnt_authenticated()
    {
        $this->json('GET', 'admin/reports')
             ->assertStatus(401);
    }

    public function test_it_returns_a_collection_of_categories()
    {
        $report = factory(Report::class)->create();

        $admin = factory(Admin::class)->create();

        $response = $this->jsonAsAdmin($admin, 'GET', 'admin/reports');

        $response->assertJsonFragment([
            'title' => $report->title,
        ]);
    }

    public function test_it_has_paginated_data() {
        $admin = factory(Admin::class)->create();

        $response = $this->jsonAsAdmin($admin, 'GET', 'admin/reports')
             ->assertJsonStructure([
                 'meta'
             ]);
    }

    public function testIndexQuery()
    {
        for ($i = 0; $i < 30; $i++) {
            factory('App\Models\Report')->create();
        }

        // searchように作成
        $report = new Report;

        $report->title   = 'dummy';
        $report->content = 'dummy_content';
        $report->status  = 0;

        $report->save();

        // pagingとpage数のテスト
        $admin = factory(Admin::class)->create();

        $data = $this->jsonAsAdmin(
            $admin,
            'GET',
            '/admin/reports?per_page=5&page=2'
        )->assertStatus(200)
                     ->decodeResponseJson();

        $this->assertEquals($data['meta']['per_page'], 5);
        $this->assertEquals($data['meta']['current_page'], 2);
        $this->assertEquals($data['links']['last'], 'http://localhost/admin/reports?page=7');

        // searchのテスト
        $admin = factory(Admin::class)->create();

        $data = $this->jsonAsAdmin(
            $admin,
            'GET',
            '/admin/reports?s=dummy'
        )->assertStatus(200)
                     ->decodeResponseJson();

        $this->assertEquals($data['meta']['per_page'], 20);
        $this->assertEquals($data['meta']['current_page'], 1);
        $this->assertEquals($data['links']['last'], 'http://localhost/admin/reports?page=1');
        $this->assertEquals($data['meta']['total'], 1);
    }
}

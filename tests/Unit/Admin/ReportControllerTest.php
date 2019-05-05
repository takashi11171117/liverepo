<?php

namespace Tests\Unit\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Report;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexRouting()
    {
        $report = factory('App\Report')->create();

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $data = $this->json(
            'GET',
            '/admin/report',
            [],
            $headers
        )->assertStatus(200)
         ->decodeResponseJson();

        $this->assertEquals($data['data'][0]['title'], $report->getAttribute('title'));
        $this->assertEquals($data['data'][0]['content'], $report->getAttribute('content'));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexPaging()
    {
        for ($i = 0; $i < 30; $i++) {
            factory('App\Report')->create();
        }

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $data = $this->json(
            'GET',
            '/admin/report',
            [],
            $headers
        )->assertStatus(200)
                     ->decodeResponseJson();

        $this->assertEquals($data['per_page'], 20);
        $this->assertEquals($data['current_page'], 1);
        $this->assertEquals($data['last_page_url'], 'http://localhost/admin/report?page=2');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexQuery()
    {
        for ($i = 0; $i < 30; $i++) {
            factory('App\Report')->create();
        }

        // searchように作成
        $report = new Report;

        $report->title     = 'dummy';
        $report->content    = 'dummy_content';
        $report->status    = 0;

        $report->save();

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        // pagingとpage数のテスト
        $data = $this->json(
            'GET',
            '/admin/report?per_page=5&page=2',
            [],
            $headers
        )->assertStatus(200)
                     ->decodeResponseJson();

        $this->assertEquals($data['per_page'], 5);
        $this->assertEquals($data['current_page'], 2);
        $this->assertEquals($data['last_page_url'], 'http://localhost/admin/report?page=7');

        // searchのテスト
        $data = $this->json(
            'GET',
            '/admin/report?s=dummy',
            [],
            $headers
        )->assertStatus(200)
                     ->decodeResponseJson();

        $this->assertEquals($data['per_page'], 20);
        $this->assertEquals($data['current_page'], 1);
        $this->assertEquals($data['last_page_url'], 'http://localhost/admin/report?page=1');
        $this->assertEquals($data['total'], 1);
    }
}

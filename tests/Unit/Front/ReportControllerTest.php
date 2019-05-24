<?php

namespace Tests\Unit\Front;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexRouting()
    {
        $report = factory('App\Report')->create();
        $report->status = 1;
        $report->save();

        $report2 = factory('App\Report')->create();
        $report2->status = 0;
        $report2->save();

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];

        $data = $this->json(
            'GET',
            '/',
            [],
            $headers
        )->assertStatus(200)
         ->decodeResponseJson();

        $this->assertEquals(count($data['data']), 1);
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
            $report = factory('App\Report')->create();
            $report->status = 1;
            $report->save();
        }

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $data = $this->json(
            'GET',
            '/',
            [],
            $headers
        )->assertStatus(200)
                     ->decodeResponseJson();

        $this->assertEquals($data['per_page'], 20);
        $this->assertEquals($data['current_page'], 1);
        $this->assertEquals($data['last_page_url'], 'http://localhost?page=2');
    }
}

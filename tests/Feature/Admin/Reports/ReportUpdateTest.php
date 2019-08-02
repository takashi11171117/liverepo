<?php

namespace Tests\Feature\Admin\Reports;

use App\Models\Admin;
use App\Models\Report;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportUpdateTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $response = $this->json('PUT', '/admin/reports/1')
                         ->assertStatus(401);
    }

    public function test_it_fails_if_a_report_cant_be_found()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', "/admin/reports/100", [
            'title' => 'test2',
            'content' => 'test_content2',
            'status' => 0,
            'rating'  => '1',
            'tags' => 'aaaaa,77777,66666'
        ])
            ->assertStatus(404);
    }

    public function test_it_requires_a_title()
    {
        $report = factory(Report::class)->create();

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', "/admin/reports/{$report->id}")
             ->assertJsonValidationErrors(['title']);
    }

    public function test_it_requires_a_content()
    {
        $report = factory(Report::class)->create();

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', "/admin/reports/{$report->id}")
             ->assertJsonValidationErrors(['content']);
    }

    public function test_it_requires_a_status()
    {
        $report = factory(Report::class)->create();

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', "/admin/reports/{$report->id}")
             ->assertJsonValidationErrors(['status']);
    }

    public function test_it_requires_a_rating()
    {
        $report = factory(Report::class)->create();

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', "/admin/reports/{$report->id}")
             ->assertJsonValidationErrors(['rating']);
    }

    public function test_it_does_not_require_report_images()
    {
        $report = factory(Report::class)->create();

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', "/admin/reports/{$report->id}", [
            'title' => 'test2',
            'content' => 'test_content2',
            'status' => 0,
            'rating'  => '1',
            'tags' => 'aaaaa,77777,66666'
        ]);

        $this->assertDatabaseHas('reports', [
            'title' => 'test2',
            'content' => 'test_content2',
            'status' => 0,
            'rating'  => '1',
        ]);
    }

    public function test_it_cat_not_upload_file_except_image()
    {
        $report = factory(Report::class)->create();

        \Storage::fake('s3');
        $file = UploadedFile::fake()->create('dummy.pdf');

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', "/admin/reports/{$report->id}", [
            'title' => 'test',
            'content' => 'test_content',
            'status' => 0,
            'rating'  => '1',
            'images'  => [$file],
            'tags' => 'aaaaa,77777'
        ])
             ->assertJsonValidationErrors(['images.0']);
    }

    public function test_it_cat_not_upload_over_10000_file()
    {
        $report = factory(Report::class)->create();

        \Storage::fake('s3');
        $file = UploadedFile::fake()->image('dummy.jpg')->size(11000);

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', "/admin/reports/{$report->id}", [
            'title' => 'test',
            'content' => 'test_content',
            'status' => 0,
            'rating'  => '1',
            'images'  => [$file],
            'tags' => 'aaaaa,77777'
        ])
             ->assertJsonValidationErrors(['images.0']);
    }

    public function test_it_can_create_an_report()
    {
        $report = factory(Report::class)->create();

        \Storage::fake('s3');
        $file = UploadedFile::fake()->image('dummy.jpg');

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'PUT', "/admin/reports/{$report->id}", [
            'title' => 'test',
            'content' => 'test_content',
            'status' => 0,
            'rating'  => '1',
            'images'  => [$file],
            'tags' => 'aaaaa,77777'
        ]);

        $report = Report::orderBy('id', 'asc')->first();

        $this->assertDatabaseHas('report_images', [
            'path' => $report->id . '_01.jpg',
        ]);

        $this->assertDatabaseHas('reports', [
            'title' => 'test',
            'content' => 'test_content',
            'status' => 0,
            'rating'  => '1',
        ]);

        $this->assertDatabaseHas('report_tags', [
            'name' => 'aaaaa',
        ]);
    }
}

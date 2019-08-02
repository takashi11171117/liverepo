<?php

namespace Tests\Feature\Admin\Reports;

use App\Models\Admin;
use App\Models\Report;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Storage;

class ReportStoreTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $response = $this->json('POST', 'admin/reports')
                         ->assertStatus(401);
    }

    public function test_it_requires_a_title()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/reports', [
            'content' => 'test_content',
            'status' => 0,
            'rating'  => '1',
            'images'  => [null],
            'tags' => 'aaaaa,77777'
        ])
             ->assertJsonValidationErrors(['title']);
    }

    public function test_it_requires_a_content()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/reports')
             ->assertJsonValidationErrors(['content']);
    }

    public function test_it_requires_a_status()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/reports')
             ->assertJsonValidationErrors(['status']);
    }

    public function test_it_requires_a_rating()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/reports')
             ->assertJsonValidationErrors(['rating']);
    }

    public function test_it_requires_tags()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/reports')
             ->assertJsonValidationErrors(['tags']);
    }

    public function test_it_requires_repote_images()
    {
        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/reports', [
            'title' => 'test',
            'content' => 'test_content',
            'status' => 0,
            'rating'  => '1',
            'images'  => [null],
            'tags' => 'aaaaa,77777'
        ])
             ->assertJsonValidationErrors(['images.0']);
    }

    public function test_it_cat_not_upload_file_except_image()
    {
        Storage::fake('s3');
        $file = UploadedFile::fake()->create('dummy.pdf');

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/reports', [
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
        Storage::fake('s3');
        $file = UploadedFile::fake()->image('dummy.jpg')->size(11000);

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/reports', [
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
        Storage::fake('s3');
        $file = UploadedFile::fake()->image('dummy.jpg');

        $admin = factory(Admin::class)->create();

        $this->jsonAsAdmin($admin, 'POST', 'admin/reports', [
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

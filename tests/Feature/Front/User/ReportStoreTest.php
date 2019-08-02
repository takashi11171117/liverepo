<?php

namespace Tests\Feature\Front\User;

use App\Models\Report;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Storage;

class ReportStoreTest extends TestCase
{
    public function test_it_fails_if_unauthenticated()
    {
        $response = $this->json('POST', 'setting/report/1')
                         ->assertStatus(401);
    }

    public function test_it_requires_a_title()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/report/{$user->id}", [
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
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/report/{$user->id}")
             ->assertJsonValidationErrors(['content']);
    }

    public function test_it_requires_a_status()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/report/{$user->id}")
             ->assertJsonValidationErrors(['status']);
    }

    public function test_it_requires_a_rating()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/report/{$user->id}")
             ->assertJsonValidationErrors(['rating']);
    }

    public function test_it_requires_tags()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/report/{$user->id}")
             ->assertJsonValidationErrors(['tags']);
    }

    public function test_it_requires_repote_images()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/report/{$user->id}", [
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

        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/report/{$user->id}", [
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

        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/report/{$user->id}", [
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

        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/report/{$user->id}", [
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
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('report_tags', [
            'name' => 'aaaaa',
        ]);
    }
}

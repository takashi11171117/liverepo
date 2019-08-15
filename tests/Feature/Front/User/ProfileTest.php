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
        $response = $this->json('POST', 'setting/profile')
                         ->assertStatus(401);
    }

    public function test_it_can_not_apply_user_name01_over_255_length()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile", [
            'user_name01' => str_repeat('test_content', 22),
        ])
             ->assertJsonFragment([
                 'user_name01' => ["姓は255文字以下にしてください。"]
             ]);
    }

    public function test_it_can_not_apply_user_name02_over_255_length()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile", [
            'user_name02' => str_repeat('test_content', 22),
        ])
             ->assertJsonFragment([
                 'user_name02' => ["名は255文字以下にしてください。"]
             ]);
    }

    public function test_it_cat_not_upload_file_except_image()
    {
        Storage::fake('s3');
        $file = UploadedFile::fake()->create('dummy.pdf');

        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile", [
            'image'  => $file,
        ])
             ->assertJsonFragment([
                 'image' => ["アイコンは画像にしてください。"]
             ]);
    }

    public function test_it_cat_not_upload_over_20000_file()
    {
        Storage::fake('s3');
        $file = UploadedFile::fake()->image('dummy.jpg')->size(21000);

        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile", [
            'image' => $file,
        ])
             ->assertJsonFragment([
                 'image' => ["アイコンは20000 KB以下のファイルにしてください。"]
             ]);
    }

    public function test_it_requires_a_birth()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile")
             ->assertJsonValidationErrors(['birth']);
    }

    public function test_it_can_not_apply_birth_when_it_is_not_date()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile", [
            'birth' => 'aaaaa',
        ])
            ->assertJsonFragment([
                'birth' => ["生年月日は正しい日付ではありません。"]
            ]);
    }

    public function test_it_requires_a_user_id()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile")
             ->assertJsonValidationErrors(['user_id']);
    }

    public function test_it_can_not_apply_user_id_when_it_is_not_numeric()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile", [
            'user_id' => 'aaaaa',
        ])
             ->assertJsonFragment([
                 'user_id' => ["user idは数字にしてください。"]
             ]);
    }


    public function test_it_can_not_apply_url_when_it_is_not_url()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile", [
            'url' => 'aaaaa',
        ])
             ->assertJsonFragment([
                 'url' => ["urlの書式が正しくありません。"]
             ]);
    }

    public function test_it_requires_a_gender()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile")
             ->assertJsonValidationErrors(['gender']);
    }

    public function test_it_can_not_apply_gender_when_it_is_not_numeric()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile", [
            'gender' => 'aaaaa',
        ])
             ->assertJsonFragment([
                 'gender' => ["性別は数字にしてください。"]
             ]);
    }

    public function test_it_requires_a_show_mail_flg()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile")
             ->assertJsonValidationErrors(['show_mail_flg']);
    }

    public function test_it_can_not_apply_show_mail_flg_when_it_is_not_numeric()
    {
        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile", [
            'show_mail_flg' => 'aaaaa',
        ])
             ->assertJsonFragment([
                 'show_mail_flg' => ["メールアドレス表示は数字にしてください。"]
             ]);
    }

    public function test_it_can_update_user_profile()
    {
        Storage::fake('s3');
        $file = UploadedFile::fake()->image('dummy.jpg');

        $user = factory(User::class)->create();

        $this->jsonAsUser($user, 'POST', "setting/profile", [
            'user_id' => 1,
            'user_name01' => 'test',
            'user_name02' => 'test2',
            'gender' => '1',
            'show_mail_flg'  => '1',
            'birth' => (new \DateTime())->format('Y/m/d'),
            'image'  => $file,
            'url' => 'http://example.com',
        ]);

        $user = User::orderBy('id', 'asc')->first();

        $this->assertDatabaseHas('users', [
            'user_name01' => 'test',
            'user_name02' => 'test2',
            'gender' => '1',
            'show_mail_flg'  => '1',
            'url' => 'http://example.com',
            'birth' => (new \DateTime())->format('Y/m/d'),
            'id' => $user->id,
        ]);
    }
}

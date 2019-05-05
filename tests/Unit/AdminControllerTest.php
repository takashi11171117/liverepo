<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Admin;

class AdminControllerTest extends TestCase
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
        $admin = factory('App\Admin')->create();

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $data = $this->json(
            'GET',
            '/admin/admin',
            [],
            $headers
        )->assertStatus(200)
        ->decodeResponseJson();

        $this->assertEquals($data['data'][0]['name'], $admin->getAttribute('name'));
        $this->assertEquals($data['data'][0]['email'], $admin->getAttribute('email'));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexPaging()
    {
        for ($i = 0; $i < 30; $i++) {
            factory('App\Admin')->create();
        }

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $data = $this->json(
            'GET',
            '/admin/admin',
            [],
            $headers
        )->assertStatus(200)
         ->decodeResponseJson();

        $this->assertEquals($data['per_page'], 20);
        $this->assertEquals($data['current_page'], 1);
        $this->assertEquals($data['last_page_url'], 'http://localhost/admin/admin?page=2');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexQuery()
    {
        for ($i = 0; $i < 30; $i++) {
            factory('App\Admin')->create();
        }

        // searchように作成
        $admin = new Admin;

        $admin->name     = 'dummy';
        $admin->email    = 'info@dummy.com';
        $admin->password = password_hash('pass', PASSWORD_DEFAULT);

        $admin->save();

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        // pagingとpage数のテスト
        $data = $this->json(
            'GET',
            '/admin/admin?per_page=5&page=2',
            [],
            $headers
        )->assertStatus(200)
        ->decodeResponseJson();

        $this->assertEquals($data['per_page'], 5);
        $this->assertEquals($data['current_page'], 2);
        $this->assertEquals($data['last_page_url'], 'http://localhost/admin/admin?page=7');

        // searchのテスト
        $data = $this->json(
            'GET',
            '/admin/admin?s=dummy',
            [],
            $headers
        )->assertStatus(200)
         ->decodeResponseJson();

        $this->assertEquals($data['per_page'], 20);
        $this->assertEquals($data['current_page'], 1);
        $this->assertEquals($data['last_page_url'], 'http://localhost/admin/admin?page=1');
        $this->assertEquals($data['total'], 1);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
        factory('App\Admin')->create();

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];
        $data = $this->json(
            'GET',
            '/admin/admin',
            [],
            $headers
        )->assertStatus(200)
         ->decodeResponseJson();

        $this->assertEquals($data['total'], 1);

        $this->json(
            'POST',
            '/admin/admin/add',
            [
                'name'                  => 'dummy',
                'email'                 => 'info@dummy.com',
                'password'              => '3387Ezweb',
                'password_confirmation' => '3387Ezweb',
            ],
            $headers
        )->assertStatus(200);

        $data = $this->json(
            'GET',
            '/admin/admin',
            [],
            $headers
        )->assertStatus(200)
         ->decodeResponseJson();

        $this->assertEquals($data['total'], 2);
    }

    public function testStoreErrorRequired()
    {
        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $data = $this->json(
            'POST',
            '/admin/admin/add',
            [
                'name'                  => '',
                'email'                 => '',
                'password'              => '',
                'password_confirmation' => '3387Ezweb',
            ],
            $headers
        )->assertStatus(422)
         ->decodeResponseJson();

        $this->assertEquals($data['errors']['name'], ['名前は必須です。']);
        $this->assertEquals($data['errors']['email'], ['メールアドレスは必須です。']);
        $this->assertEquals($data['errors']['password'], ['パスワードは必須です。']);
    }

    public function testStoreErrorEmail()
    {
        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $data = $this->json(
            'POST',
            '/admin/admin/add',
            [
                'name'                  => 'dummy',
                'email'                 => 'infodummy.com',
                'password'              => '3387Ezweb',
                'password_confirmation' => '3387Ezweb',
            ],
            $headers
        )->assertStatus(422)
         ->decodeResponseJson();

        $this->assertEquals($data['errors']['email'], ['メールアドレスを正しいメールアドレスにしてください。']);
    }

    public function testStoreErrorPassword()
    {
        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $data = $this->json(
            'POST',
            '/admin/admin/add',
            [
                'name'                  => 'dummy',
                'email'                 => 'info@dummy.com',
                'password'              => '3387Ezweb',
                'password_confirmation' => '3387Ezwe',
            ],
            $headers
        )->assertStatus(422)
         ->decodeResponseJson();

        $this->assertEquals($data['errors']['password'], ['パスワードが異なります。']);

        $data = $this->json(
            'POST',
            '/admin/admin/add',
            [
                'name'                  => 'dummy',
                'email'                 => 'info@dummy.com',
                'password'              => '3387',
                'password_confirmation' => '3387',
            ],
            $headers
        )->assertStatus(422)
         ->decodeResponseJson();

        $this->assertEquals($data['errors']['password'], ['８文字以上、アルファベット・数字を、最低1文字以上は使用してください。']);
    }

    public function testShowRouting()
    {
        $admin = factory('App\Admin')->create();

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $data = $this->json(
            'GET',
            '/admin/admin/1',
            [],
            $headers
        )->assertStatus(200)
         ->decodeResponseJson();

        $this->assertEquals($data['name'], $admin->getAttribute('name'));
        $this->assertEquals($data['email'], $admin->getAttribute('email'));
    }

    public function testUpdate()
    {
        factory('App\Admin')->create();

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $data = $this->json(
            'PUT',
            '/admin/admin/1/update',
            [
                'name'                  => 'dummy',
                'email'                 => 'info@dummy.com',
                'password'              => '3387Ezweb',
                'password_confirmation' => '3387Ezweb',
            ],
            $headers
        )->assertStatus(200)
         ->decodeResponseJson();

        $this->assertEquals($data['name'], 'dummy');
        $this->assertEquals($data['email'], 'info@dummy.com');
    }

    public function testUpdateErrorRequired()
    {
        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $data = $this->json(
            'PUT',
            '/admin/admin/1/update',
            [
                'name'                  => '',
                'email'                 => '',
                'password'              => '',
                'password_confirmation' => '',
            ],
            $headers
        )->assertStatus(422)
         ->decodeResponseJson();

        $this->assertEquals($data['errors']['name'], ['名前は必須です。']);
        $this->assertEquals($data['errors']['email'], ['メールアドレスは必須です。']);
    }

    public function testUpdateErrorEmail()
    {
        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $data = $this->json(
            'PUT',
            '/admin/admin/1/update',
            [
                'name'                  => 'dummy',
                'email'                 => 'infodummy.com',
                'password'              => '',
                'password_confirmation' => '',
            ],
            $headers
        )->assertStatus(422)
         ->decodeResponseJson();

        $this->assertEquals($data['errors']['email'], ['メールアドレスを正しいメールアドレスにしてください。']);
    }

    public function testUpdateErrorPassword()
    {
        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $data = $this->json(
            'PUT',
            '/admin/admin/1/update',
            [
                'name'                  => 'dummy',
                'email'                 => 'info@dummy.com',
                'password'              => '3387Ezweb',
                'password_confirmation' => '3387Ezwe',
            ],
            $headers
        )->assertStatus(422)
         ->decodeResponseJson();

        $this->assertEquals($data['errors']['password'], ['パスワードが異なります。']);

        $data = $this->json(
            'PUT',
            '/admin/admin/1/update',
            [
                'name'                  => 'dummy',
                'email'                 => 'info@dummy.com',
                'password'              => '3387',
                'password_confirmation' => '3387',
            ],
            $headers
        )->assertStatus(422)
         ->decodeResponseJson();

        $this->assertEquals($data['errors']['password'], ['８文字以上、アルファベット・数字を、最低1文字以上は使用してください。']);
    }

    public function testDestroyRouting()
    {
        factory('App\Admin')->create();

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            "Authorization" => "Bearer",
        ];

        $this->json(
            'DELETE',
            '/admin/admin/1/delete?page=1',
            [],
            $headers
        )->assertStatus(301);

        $data = $this->json(
            'GET',
            '/admin/admin',
            [],
            $headers
        )->assertStatus(200)
         ->decodeResponseJson();

        $this->assertEquals($data['total'], 0);
    }
}

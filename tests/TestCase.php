<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Contracts\JWTSubject;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public function jsonAsAdmin(JWTSubject $admin, $method, $endpoint, $data = [], $headers = [])
    {
        $token = auth('admins')->tokenById($admin->id);

        return $this->json($method, $endpoint, $data, array_merge($headers, [
            'Authorization' => 'Bearer ' . $token
        ]));
    }

    public function jsonAsUser(JWTSubject $user, $method, $endpoint, $data = [], $headers = [])
    {
        $token = auth()->tokenById($user->id);

        return $this->json($method, $endpoint, $data, array_merge($headers, [
            'Authorization' => 'Bearer ' . $token
        ]));
    }
}

<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\User\Entities\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected const TOKEN_NAME = 'bonjour';
    protected const AUTHENTICATION_LOGIN = 'api/v1/authentication/login';

    protected User $testingUser;

    public function getAuthorizationHeaders():array
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->testingUser->createToken(self::TOKEN_NAME)->plainTextToken,
        ];
    }

    public function getLoginKey(string $email):string
    {
        $response = $this->post(
            self::AUTHENTICATION_LOGIN,
            [
                'login' => $email,
            ]
        );
        return $response->json()['data']['key'];
    }

    public function getUserForTest(array $userData = []):User
    {
        return User::factory()
            ->create($userData);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->testingUser = $this->getUserForTest();
    }
}

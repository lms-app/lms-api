<?php
declare(strict_types=1);

namespace Modules\Authentication\Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * @group functional
 * @group authentication
 */
final class PasswordTest extends TestCase
{
    private string $endpoint = 'api/v1/authentication/password';
    private const PASSWORD = '1234SuperPassword';
    private const WRONG_PASSWORD = 'wrong';

    public function testItGetTokenBecausePasswordIsCorrect():void
    {
        $this->testingUser->setAttribute('password', Hash::make(self::PASSWORD));
        $this->testingUser->save();

        $response = $this->post(
            $this->endpoint,
            [
                'password' => self::PASSWORD,
                'key' => $this->getLoginKey($this->testingUser->getEmail()),
            ]
        );

        $response->assertOk();
        $response->assertSee(['token']);
    }

    public function testItFailsPasswordBecausePasswordIsInvalid():void
    {
        $this->testingUser->setAttribute('password', Hash::make(self::PASSWORD));
        $this->testingUser->save();

        $response = $this->post(
            $this->endpoint,
            [
                'password' => self::WRONG_PASSWORD,
                'key' => $this->getLoginKey($this->testingUser->getEmail()),
            ]
        );

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertSee(['Wrong password']);
    }
}

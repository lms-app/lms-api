<?php
declare(strict_types=1);

namespace Modules\Authentication\Tests\Feature;

use Tests\TestCase;

/**
 * @group functional
 * @group authentication
 */
final class LoginTest extends TestCase
{
    private string $endpoint = 'api/v1/authentication/login';
    private const EMAIL = 'test@lms.com';

    public function testItGetsLoginKey():void
    {
        $response = $this->post(
            $this->endpoint,
            [
                'login' => self::EMAIL,
            ],
            $this->getAuthorizationHeaders()
        );

        $response->assertOk();
        $response->assertSee(['key']);
    }
}

<?php
declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Modules\Authorization\ValueObjects\Role;
use Tests\TestCase;

final class UserProfileTest extends TestCase
{
    private string $endpoint = 'api/v1/user/profile';

    public function testItGetsUserProfile():void
    {
        $this->testingUser->assignRole(Role::ADMINISTRATOR);
        $response = $this->get(
            $this->endpoint,
            $this->getAuthorizationHeaders()
        );
        $response->assertOk();
        $rules = $response->json()['data'][0]['rules'];
//        var_dump($rules);
//        self::assertTrue(in_array(CoursePermission::SUBJECT, $rules));
    }
}

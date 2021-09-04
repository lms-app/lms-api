<?php

declare(strict_types=1);

namespace Modules\Course\Tests\Feature;

use Modules\Course\ValueObjects\CoursePermission;
use Modules\Course\Tests\CourseTestCase;
use Modules\Entity\Enums\EntityTypesEnum;
use Modules\Entity\Exceptions\InvalidEntityStatusException;
use Modules\Entity\ValueObjects\EntityStatus;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 * @group course
 */
final class CreateCourseTest extends CourseTestCase
{
    protected string $endpoint = 'api/v1/course';

    public function testItCreatesCourse():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::CREATE
        );

        $response = $this->post(
            $this->endpoint,
            [
                'status' => EntityStatus::STATUS_OPEN,
            ],
            $this->getAuthorizationHeaders()
        );

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertSee(['entity' => EntityTypesEnum::TYPE_COURSE]);
        $response->assertSee(['status' => EntityStatus::STATUS_OPEN]);
    }

    public function testItFailCreatesCourseBecauseStatusIsInvalid():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::CREATE
        );

        $response = $this->post(
            $this->endpoint,
            [
                'status' => 'notexiststatus',
            ],
            $this->getAuthorizationHeaders()
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertSee(InvalidEntityStatusException::ENTITY_STATUS_INVALID_MESSAGE);
    }
}

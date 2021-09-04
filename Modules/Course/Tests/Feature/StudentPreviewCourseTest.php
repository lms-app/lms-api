<?php
declare(strict_types=1);

namespace Modules\Course\Tests\Feature;

use Modules\Course\ValueObjects\CoursePermission;
use Modules\Course\Tests\CourseTestCase;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityStatus;
use Modules\Entity\ValueObjects\EntityType;

/**
 * @group functional
 * @group course
 */
final class StudentPreviewCourseTest extends CourseTestCase
{
    private string $endpoint = 'api/v1/course/%d/preview';

    public function testItGetsCourseBecauseUserIsStudent():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::SEE_AS_STUDENT
        );

        $course = Entity::factory()->create(
            [
                'entity_type' => EntityType::TYPE_COURSE,
                'status' => EntityStatus::STATUS_OPEN,
                'author_id' => $this->testingUser->getAuthorId(),
            ]
        );

        $this->endpoint = sprintf(
            $this->endpoint,
            $course->getAttribute('id')
        );

        $response = $this->get(
            $this->endpoint,
            $this->getAuthorizationHeaders()
        );

        $response->assertOk();
        $response->assertSee(['entity' => EntityType::TYPE_COURSE]);
    }
}

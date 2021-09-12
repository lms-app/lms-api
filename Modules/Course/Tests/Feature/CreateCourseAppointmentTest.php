<?php

declare(strict_types=1);

namespace Modules\Course\Tests\Feature;

use Modules\Appointment\ValueObjects\AppointmentStatus;
use Modules\Course\Entities\Course;
use Modules\Course\Http\Controllers\CourseController;
use Modules\Course\Tests\CourseTestCase;
use Modules\Course\ValueObjects\CoursePermission;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 * @group course
 * @see CourseController::createAppointment()
 */
final class CreateCourseAppointmentTest extends CourseTestCase
{
    protected string $endpoint = '/api/v1/course/%d/appointment';

    public function testItCreatesCourseAppointment():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::PASS_AS_STUDENT
        );

        $entity = Entity::factory()->create(
            [
                'author_id' => $this->getUserForTest()->getAuthorId(),
                'entity_type' => EntityType::TYPE_COURSE,
            ]
        );

        $course = Course::factory()->create(
            [
                'entity_id' => $entity->getAttribute('id'),
            ]
        );

        $this->endpoint = sprintf($this->endpoint, $course->getAttribute('entity_id'));

        $response = $this->post(
            $this->endpoint,
            [

            ],
            $this->getAuthorizationHeaders()
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee(['status' => AppointmentStatus::ASSIGNED]);
    }
}

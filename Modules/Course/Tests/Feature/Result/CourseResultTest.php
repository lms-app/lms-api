<?php
declare(strict_types=1);

namespace Modules\Course\Tests\Feature\Result;


use DateTimeImmutable;
use Modules\Appointment\Entities\Appointment;
use Modules\Appointment\ValueObjects\AppointmentStatus;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseElement;
use Modules\Course\Entities\CourseSection;
use Modules\Course\Tests\CourseTestCase;
use Modules\Course\ValueObjects\CourseElement as CourseElementValue;
use Modules\Course\ValueObjects\CoursePermission;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityStatus;
use Modules\Entity\ValueObjects\EntityType;

final class CourseResultTest extends CourseTestCase
{
    private string $endpoint = 'api/v1/course/appointment/%d/result';

    public function testItCreatesCourseElementResult():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::PASS_AS_STUDENT
        );

        /** @var Entity $entity */
        $entity = Entity::factory()->create(
            [
                'entity_type' => EntityType::TYPE_COURSE,
                'status' => EntityStatus::STATUS_OPEN,
                'author_id' => $this->testingUser->getAuthorId(),
            ]
        );

        $course = Course::factory()->create(
            [
                'entity_id' => $entity->getAttribute('id'),
            ]
        );

        /** @var CourseSection $courseSection */
        $courseSection = CourseSection::factory()->create(
            [
                'author_id' => $this->getUserForTest()->getId(),
                'entity_id' => $entity->getId(),
            ]
        );

        $courseSectionElement = CourseElement::factory()->create(
            [
                'author_id' => $this->getUserForTest()->getId(),
                'section_id' => $courseSection->getId(),
                'type' => CourseElementValue::TYPE_PDF,
                'title' => self::TITLE,
                'attempt_count' => self::ATTEMPT_COUNT,
                'pass_score' => self::HUNDRED_SCORE,
            ]
        );

        $appointment = Appointment::factory()->create(
            [
                'user_id' => $this->testingUser->getId(),
                'entity_id' => $entity->getId(),
                'date_start' => (new DateTimeImmutable('now'))->format('Y-m-d H:i:s'),
                'date_end' => (new DateTimeImmutable('tomorrow'))->format('Y-m-d H:i:s'),
                'status' => AppointmentStatus::IN_PROGRESS,
                'attempts_max' => self::ATTEMPT_COUNT,
            ]
        );

        $this->endpoint = sprintf(
            $this->endpoint,
            $appointment->getAttribute('id')
        );

        $response = $this->post(
            $this->endpoint,
            [
                'element_id' => $courseSectionElement->getAttribute('id'),
            ],
            $this->getAuthorizationHeaders()
        );

        $response->assertOk();
    }

    public function testItCreatesCourseSectionResult():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::PASS_AS_STUDENT
        );

        /** @var Entity $entity */
        $entity = Entity::factory()->create(
            [
                'entity_type' => EntityType::TYPE_COURSE,
                'status' => EntityStatus::STATUS_OPEN,
                'author_id' => $this->testingUser->getAuthorId(),
            ]
        );

        $course = Course::factory()->create(
            [
                'entity_id' => $entity->getAttribute('id'),
            ]
        );

        /** @var CourseSection $courseSection */
        $courseSection = CourseSection::factory()->create(
            [
                'author_id' => $this->getUserForTest()->getId(),
                'entity_id' => $entity->getId(),
            ]
        );

        $courseSectionElement = CourseElement::factory()->create(
            [
                'author_id' => $this->getUserForTest()->getId(),
                'section_id' => $courseSection->getId(),
                'type' => CourseElementValue::TYPE_PDF,
                'title' => self::TITLE,
                'attempt_count' => self::ATTEMPT_COUNT,
                'pass_score' => self::HUNDRED_SCORE,
            ]
        );

        $appointment = Appointment::factory()->create(
            [
                'user_id' => $this->testingUser->getId(),
                'entity_id' => $entity->getId(),
                'date_start' => (new DateTimeImmutable('now'))->format('Y-m-d H:i:s'),
                'date_end' => (new DateTimeImmutable('tomorrow'))->format('Y-m-d H:i:s'),
                'status' => AppointmentStatus::IN_PROGRESS,
                'attempts_max' => self::ATTEMPT_COUNT,
            ]
        );

        $this->endpoint = sprintf(
            $this->endpoint,
            $appointment->getAttribute('id')
        );

        $response = $this->post(
            $this->endpoint,
            [
                'section_id' => $courseSection->getAttribute('id'),
            ],
            $this->getAuthorizationHeaders()
        );

        $response->assertOk();
    }

    public function testItCreatesCourseAppointmentResult():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::PASS_AS_STUDENT
        );

        /** @var Entity $entity */
        $entity = Entity::factory()->create(
            [
                'entity_type' => EntityType::TYPE_COURSE,
                'status' => EntityStatus::STATUS_OPEN,
                'author_id' => $this->testingUser->getAuthorId(),
            ]
        );

        $course = Course::factory()->create(
            [
                'entity_id' => $entity->getAttribute('id'),
            ]
        );

        /** @var CourseSection $courseSection */
        $courseSection = CourseSection::factory()->create(
            [
                'author_id' => $this->getUserForTest()->getId(),
                'entity_id' => $entity->getId(),
            ]
        );

        $courseSectionElement = CourseElement::factory()->create(
            [
                'author_id' => $this->getUserForTest()->getId(),
                'section_id' => $courseSection->getId(),
                'type' => CourseElementValue::TYPE_PDF,
                'title' => self::TITLE,
                'attempt_count' => self::ATTEMPT_COUNT,
                'pass_score' => self::HUNDRED_SCORE,
            ]
        );

        $appointment = Appointment::factory()->create(
            [
                'user_id' => $this->testingUser->getId(),
                'entity_id' => $entity->getId(),
                'date_start' => (new DateTimeImmutable('now'))->format('Y-m-d H:i:s'),
                'date_end' => (new DateTimeImmutable('tomorrow'))->format('Y-m-d H:i:s'),
                'status' => AppointmentStatus::IN_PROGRESS,
                'attempts_max' => self::ATTEMPT_COUNT,
            ]
        );

        $this->endpoint = sprintf(
            $this->endpoint,
            $appointment->getAttribute('id')
        );

        $response = $this->post(
            $this->endpoint,
            [],
            $this->getAuthorizationHeaders()
        );

        $response->assertOk();
    }
}

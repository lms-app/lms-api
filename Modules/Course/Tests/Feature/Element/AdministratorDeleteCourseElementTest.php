<?php

declare(strict_types=1);

namespace Modules\Course\Tests\Feature\Element;

use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseElement;
use Modules\Course\Entities\CourseSection;
use Modules\Course\Http\Controllers\CourseSectionElementController;
use Modules\Course\Tests\CourseTestCase;
use Modules\Course\ValueObjects\CourseElement as CourseElementValue;
use Modules\Course\ValueObjects\CoursePermission;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 * @group course
 * @see CourseSectionElementController::delete()
 */
final class AdministratorDeleteCourseElementTest extends CourseTestCase
{
    protected string $endpoint = 'api/v1/course/section/element/%d';

    public function testItDeleteCourseElement():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::EDIT_AS_ADMINISTRATOR
        );

        /** @var Entity $entity */
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

        /** @var CourseSection $courseSection */
        $courseSection = CourseSection::factory()->create(
            [
                'entity_id' => $entity->getId(),
            ]
        );

        $courseSectionElement = CourseElement::factory()->create(
            [
                'section_id' => $courseSection->getId(),
                'type' => CourseElementValue::TYPE_PDF,
                'title' => self::TITLE,
                'attempt_count' => 0,
                'pass_score' => 0,
            ]
        );

        $this->endpoint = sprintf($this->endpoint, $courseSectionElement->getAttribute('id'));

        $response = $this->delete(
            $this->endpoint,
            [],
            $this->getAuthorizationHeaders()
        );

        $response->assertOk();
        self::assertFalse(CourseElement::query()->exists());
    }

    public function testItForbidDeleteCourseElementBecauseUserDoesNotHavePermissions():void
    {
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

        $courseSection = CourseSection::factory()->create(
            [
                'entity_id' => $entity->getId(),
            ]
        );

        $courseSectionElement = CourseElement::factory()->create(
            [
                'section_id' => $courseSection->getId(),
                'type' => CourseElementValue::TYPE_PDF,
                'title' => self::TITLE,
                'attempt_count' => self::ATTEMPT_COUNT,
                'pass_score' => self::PASS_SCORE,
            ]
        );

        $this->endpoint = sprintf($this->endpoint, $courseSectionElement->getAttribute('id'));

        $response = $this->delete(
            $this->endpoint,
            [],
            $this->getAuthorizationHeaders()
        );
        $response->assertForbidden();
    }
}

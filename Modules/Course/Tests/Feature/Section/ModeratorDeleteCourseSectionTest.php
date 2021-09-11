<?php

declare(strict_types=1);

namespace Modules\Course\Tests\Feature\Section;

use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseSection;
use Modules\Course\Tests\CourseTestCase;
use Modules\Course\ValueObjects\CoursePermission;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;

/**
 * @group functional
 * @group course
 */
final class ModeratorDeleteCourseSectionTest extends CourseTestCase
{
    protected string $endpoint = 'api/v1/course/section/%d';

    public function testItDeleteSectionForCourse():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::EDIT_AS_MODERATOR
        );

        $entity = Entity::factory()->create(
            [
                'author_id' => $this->testingUser->getAuthorId(),
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
                'entity_id' => $entity->getAttribute('id'),
            ]
        );

        $this->endpoint = sprintf(
            $this->endpoint,
            $entity->getAttribute('id'),
            $courseSection->getAttribute('id')
        );

        $response = $this->delete(
            $this->endpoint,
            [],
            $this->getAuthorizationHeaders()
        );
        $response->assertOk();
        self::assertFalse(CourseSection::query()->exists());
    }

    public function testItForbidDeleteCourseSectionBecauseUserIsNotEntityAuthor():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::EDIT_AS_MODERATOR
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

        $courseSection = CourseSection::factory()->create(
            [
                'entity_id' => $entity->getAttribute('id'),
            ]
        );

        $this->endpoint = sprintf(
            $this->endpoint,
            $entity->getAttribute('id'),
            $courseSection->getAttribute('id')
        );

        $response = $this->delete(
            $this->endpoint,
            [],
            $this->getAuthorizationHeaders()
        );
        $response->assertForbidden();
    }
}

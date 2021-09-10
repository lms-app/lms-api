<?php
declare(strict_types=1);

namespace Modules\Course\Tests\Feature;

use Modules\Course\Entities\Course;
use Modules\Course\ValueObjects\CoursePermission;
use Modules\Course\Tests\CourseTestCase;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityStatus;
use Modules\Entity\ValueObjects\EntityType;
use Modules\Folder\Entities\Folder;
use Modules\Course\ValueObjects\CourseFolderPermission;

/**
 * @group functional
 * @group course
 */
final class ModeratorGetCourseTest extends CourseTestCase
{
    private string $endpoint = 'api/v1/course/%d';

    public function testItGetsCourseBecauseUserIsAuthor():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::SEE_AS_MODERATOR
        );

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

        $this->endpoint = sprintf(
            $this->endpoint,
            $entity->getAttribute('id')
        );

        $response = $this->get(
            $this->endpoint,
            $this->getAuthorizationHeaders()
        );

        $response->assertOk();
    }

    public function testItGetsCourseBecauseUserIsFolderModerator():void
    {
        $this->testingUser->givePermissionTo(
            CourseFolderPermission::SEE_AS_MODERATOR,
            CoursePermission::SEE_AS_MODERATOR
        );

        $folder = Folder::factory()->create(
            [
                'entity_type' => EntityType::TYPE_COURSE,
                'author_id' => $this->testingUser->getAuthorId(),
            ]
        );

        $entity = Entity::factory()->create(
            [
                'entity_type' => EntityType::TYPE_COURSE,
                'status' => EntityStatus::STATUS_OPEN,
                'author_id' => $this->testingUser->getAuthorId(),
                'folder_id' => $folder->getAttribute('id'),
            ]
        );

        $course = Course::factory()->create(
            [
                'entity_id' => $entity->getAttribute('id'),
            ]
        );

        $this->endpoint = sprintf(
            $this->endpoint,
            $entity->getAttribute('id')
        );

        $response = $this->get(
            $this->endpoint,
            $this->getAuthorizationHeaders()
        );

        $response->assertOk();
    }

    public function testItForbidGetCourseBecauseUserIsNotAuthor():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::SEE_AS_MODERATOR
        );

        $entity = Entity::factory()->create(
            [
                'entity_type' => EntityType::TYPE_COURSE,
                'status' => EntityStatus::STATUS_OPEN,
                'author_id' => $this->getUserForTest()->getAuthorId(),
            ]
        );

        $course = Course::factory()->create(
            [
                'entity_id' => $entity->getAttribute('id'),
            ]
        );

        $this->endpoint = sprintf(
            $this->endpoint,
            $entity->getAttribute('id')
        );

        $response = $this->get(
            $this->endpoint,
            $this->getAuthorizationHeaders()
        );

        $response->assertForbidden();
    }
}

<?php
declare(strict_types=1);

namespace Modules\Course\Tests\Feature;

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
final class ModeratorUpdateCourseTest extends CourseTestCase
{
    private string $endpoint = 'api/v1/course/%d';

    private const TITLE = 'Супер заголовок';

    public function testItUpdatesCourseBecauseUserIsAuthor():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::EDIT_AS_MODERATOR
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

        $response = $this->put(
            $this->endpoint,
            [
                'title' => self::TITLE,
            ],
            $this->getAuthorizationHeaders()
        );

        $data = $response->decodeResponseJson()['data'];

        $response->assertOk();
        $response->assertSee(['entity' => EntityType::TYPE_COURSE]);
        self::assertSame(self::TITLE, $data['title']);
    }

    public function testItUpdatesCourseBecauseUserIsFolderModerator():void
    {
        $this->testingUser->givePermissionTo(
            CourseFolderPermission::SEE_AS_MODERATOR,
            CoursePermission::EDIT_AS_MODERATOR
        );

        $folder = Folder::factory()->create(
            [
                'entity_type' => EntityType::TYPE_COURSE,
                'author_id' => $this->testingUser->getAuthorId(),
            ]
        );

        $course = Entity::factory()->create(
            [
                'entity_type' => EntityType::TYPE_COURSE,
                'status' => EntityStatus::STATUS_OPEN,
                'author_id' => $this->testingUser->getAuthorId(),
                'folder_id' => $folder->getAttribute('id'),
            ]
        );

        $this->endpoint = sprintf(
            $this->endpoint,
            $course->getAttribute('id')
        );

        $response = $this->put(
            $this->endpoint,
            [
                'title' => self::TITLE,
            ],
            $this->getAuthorizationHeaders()
        );

        $response->assertOk();
        $response->assertSee(['entity' => EntityType::TYPE_COURSE]);
    }

    public function testItForbidUpdateCourseBecauseUserIsNotAuthor():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::SEE_AS_MODERATOR
        );

        $course = Entity::factory()->create(
            [
                'entity_type' => EntityType::TYPE_COURSE,
                'status' => EntityStatus::STATUS_OPEN,
                'author_id' => $this->getUserForTest()->getAuthorId(),
            ]
        );

        $this->endpoint = sprintf(
            $this->endpoint,
            $course->getAttribute('id')
        );

        $response = $this->put(
            $this->endpoint,
            [
                'title' => self::TITLE,
            ],
            $this->getAuthorizationHeaders()
        );

        $response->assertForbidden();
    }
}

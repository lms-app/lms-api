<?php

declare(strict_types=1);

namespace Modules\Course\Tests\Feature\Section;

use Modules\Course\Entities\Course;
use Modules\Course\Tests\CourseTestCase;
use Modules\Course\ValueObjects\CoursePermission;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 * @group course
 * @see CourseSectionController::create()
 */
final class ModeratorCreateCourseSectionTest extends CourseTestCase
{
    protected string $endpoint = 'api/v1/course/%d/section';

    public function testItCreatesSectionForCourse():void
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

        $this->endpoint = sprintf($this->endpoint, $entity->getAttribute('id'));

        $response = $this->post(
            $this->endpoint,
            [
                'sort_order' => self::SORT_ORDER,
                'pass_score' => self::PASS_SCORE,
                'title' => self::TITLE,
                'description' => self::DESCRIPTION,
                'admin_notes' => self::ADMIN_NOTES,
                'finish_course_on_fail' => self::FINISH_COURSE_ON_FAIL,
                'show_results' => self::SHOW_RESULTS,
                'sequential_passage' => self::SEQUENTIAL_PASSAGE,
            ],
            $this->getAuthorizationHeaders()
        );

        $decodedResponse = $response->decodeResponseJson()['data'];
        self::assertSame(self::DESCRIPTION, $decodedResponse['description']);
        self::assertSame(self::ADMIN_NOTES, $decodedResponse['admin_notes']);
        self::assertSame(self::TITLE, $decodedResponse['title']);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee(['author_id' => $this->testingUser->getAuthorId()]);
        $response->assertSee(['parent_id' => null]);
        $response->assertSee(['sort_order' => self::SORT_ORDER]);
        $response->assertSee(['pass_score' => self::PASS_SCORE]);
        $response->assertSee(['finish_course_on_fail' => self::FINISH_COURSE_ON_FAIL]);
        $response->assertSee(['show_results' => self::SHOW_RESULTS]);
        $response->assertSee(['sequential_passage' => self::SEQUENTIAL_PASSAGE]);
    }

    public function testItForbidCreatesSectionForCourseBecauseUserDoesNotHavePermissions():void
    {
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

        $this->endpoint = sprintf($this->endpoint, $entity->getAttribute('id'));

        $response = $this->post(
            $this->endpoint,
            [
                'title' => self::TITLE,
            ],
            $this->getAuthorizationHeaders()
        );
        $response->assertForbidden();
    }
}

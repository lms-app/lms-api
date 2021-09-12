<?php

declare(strict_types=1);

namespace Modules\Course\Tests\Feature\Element;

use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseSection;
use Modules\Course\Http\Controllers\CourseSectionElementController;
use Modules\Course\Tests\CourseTestCase;
use Modules\Course\ValueObjects\CourseElement;
use Modules\Course\ValueObjects\CoursePermission;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 * @group course
 * @see CourseSectionElementController::create()
 */
final class ModeratorCreateCourseElementTest extends CourseTestCase
{
    protected string $endpoint = 'api/v1/course/section/%d/element';

    public function testItCreatesCourseElementBecauseUserIsCourseAuthor():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::EDIT_AS_MODERATOR
        );

        /** @var Entity $entity */
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
                'author_id' => $this->getUserForTest()->getId(),
                'entity_id' => $entity->getId(),
            ]
        );

        $this->endpoint = sprintf($this->endpoint, $courseSection->getAttribute('id'));

        $response = $this->post(
            $this->endpoint,
            [
                'sort_order' => self::SORT_ORDER,
                'pass_score' => self::PASS_SCORE,
                'title' => self::TITLE,
                'type' => CourseElement::TYPE_TEXT,
                'description' => self::DESCRIPTION,
                'attempt_count' => self::ATTEMPT_COUNT,
            ],
            $this->getAuthorizationHeaders()
        );

        $decodedResponse = $response->decodeResponseJson()['data'];
        self::assertSame(self::DESCRIPTION, $decodedResponse['description']);
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

    public function testItForbidCreatesCourseElementBecauseUserIsNotCourseAuthor():void
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
                'author_id' => $this->getUserForTest()->getId(),
                'entity_id' => $entity->getId(),
            ]
        );

        $this->endpoint = sprintf($this->endpoint, $courseSection->getAttribute('id'));

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

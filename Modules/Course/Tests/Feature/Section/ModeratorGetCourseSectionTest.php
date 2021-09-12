<?php

declare(strict_types=1);

namespace Modules\Course\Tests\Feature\Section;

use Modules\Course\Entities\Course;
use Modules\Course\Entities\CourseSection;
use Modules\Course\Tests\CourseTestCase;
use Modules\Course\ValueObjects\CoursePermission;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 * @group course
 */
final class ModeratorGetCourseSectionTest extends CourseTestCase
{
    protected string $endpoint = 'api/v1/course/section/%d';

    public function testItGetCourseSectionWhenUserIsCourseAuthor():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::SEE_AS_ADMINISTRATOR
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
                'author_id' => $this->testingUser->getId(),
                'entity_id' => $entity->getAttribute('id'),
                'sort_order' => self::SORT_ORDER,
                'pass_score' => self::PASS_SCORE,
                'title' => self::TITLE,
                'description' => self::DESCRIPTION,
                'admin_notes' => self::ADMIN_NOTES,
                'finish_course_on_fail' => self::FINISH_COURSE_ON_FAIL,
                'show_results' => self::SHOW_RESULTS,
                'sequential_passage' => self::SEQUENTIAL_PASSAGE,
            ]
        );

        $this->endpoint = sprintf(
            $this->endpoint,
            $courseSection->getAttribute('id')
        );

        $response = $this->get(
            $this->endpoint,
            $this->getAuthorizationHeaders()
        );

        $response->assertOk();

        $data = $response->decodeResponseJson()['data'];
        self::assertSame(self::DESCRIPTION, $data['description']);
        self::assertSame(self::ADMIN_NOTES, $data['admin_notes']);
        self::assertSame(self::TITLE, $data['title']);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee(['id' => $courseSection->getAttribute('id')]);
        $response->assertSee(['author_id' => $this->testingUser->getAuthorId()]);
        $response->assertSee(['parent_id' => null]);
        $response->assertSee(['sort_order' => self::SORT_ORDER]);
        $response->assertSee(['pass_score' => self::PASS_SCORE]);
        $response->assertSee(['finish_course_on_fail' => self::FINISH_COURSE_ON_FAIL]);
        $response->assertSee(['show_results' => self::SHOW_RESULTS]);
        $response->assertSee(['sequential_passage' => self::SEQUENTIAL_PASSAGE]);
    }
}

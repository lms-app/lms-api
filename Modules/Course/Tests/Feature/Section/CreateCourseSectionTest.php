<?php

declare(strict_types=1);

namespace Modules\Course\Tests\Feature\Section;

use Modules\Course\Tests\CourseTestCase;
use Modules\Course\ValueObjects\CoursePermission;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 * @group course
 */
final class CreateCourseSectionTest extends CourseTestCase
{
    protected string $endpoint = 'api/v1/course/%d/section';

    private const SORT_ORDER = 200;
    private const PASS_SCORE = 1000;
    private const TITLE = 'Секция видео';
    private const DESCRIPTION = 'Описание секции';
    private const ADMIN_NOTES = 'Заметки админа';
    private const FINISH_COURSE_ON_FAIL = true;
    private const SHOW_RESULTS = true;
    private const SEQUENTIAL_PASSAGE = true;

    public function testItCreatesSectionForCourse():void
    {
        $this->testingUser->givePermissionTo(
            CoursePermission::CREATE
        );

        $course = Entity::factory()->create(
            [
                'author_id' => $this->testingUser->getAuthorId(),
                'entity_type' => EntityType::TYPE_COURSE,
            ]
        );

        $this->endpoint = sprintf($this->endpoint, $course->getAttribute('id'));

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

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertSee(['entity_id' => $course->getAttribute('entity_id')]);
        $response->assertSee(['author_id' => $this->testingUser->getAuthorId()]);
        $response->assertSee(['parent_id' => null]);
        $response->assertSee(['sort_order' => self::SORT_ORDER]);
        $response->assertSee(['pass_score' => self::PASS_SCORE]);
        $response->assertSee(['finish_course_on_fail' => self::FINISH_COURSE_ON_FAIL]);
        $response->assertSee(['show_results' => self::SHOW_RESULTS]);
        $response->assertSee(['sequential_passage' => self::SEQUENTIAL_PASSAGE]);
    }
}

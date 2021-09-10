<?php
declare(strict_types=1);

namespace Modules\Course\Http\Responses;

use Illuminate\Http\JsonResponse;
use Modules\Course\Entities\Course;

final class CoursePreviewResponse  extends JsonResponse
{
    public static function get(Course $course):self
    {
        $entity = $course->getEntity();

        return new self(
            [
                'data' => [
                    'author_id' => $entity->getAttribute('author_id'),
                    'title' => $entity->getAttribute('title'),
                    'status' => $entity->getAttribute('status'),
                    'short_description' => $entity->getAttribute('short_description'),
                    'description' => $entity->getAttribute('description'),
                    'attempts_count' => $course->getAttribute('attempts_count'),
                    'after_finished_view_element_access' => $course->getAttribute('after_finished_view_element_access'),
                    'section_sequential_passage' => $course->getAttribute('section_sequential_passage'),
                    'members_block' => [
                        'access_date' => [],
                        'member_enterprises' => [],
                        'member_excludes' => [],
                        'member_groups' => [],
                        'member_users' => [],
                    ]
                ]
            ]
        );
    }
}

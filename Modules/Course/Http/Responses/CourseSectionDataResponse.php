<?php
declare(strict_types=1);

namespace Modules\Course\Http\Responses;

use Illuminate\Http\JsonResponse;
use Modules\Course\Entities\CourseSection;

final class CourseSectionDataResponse  extends JsonResponse
{
    public static function get(CourseSection $courseSection):self
    {
        $entity = $courseSection->getEntity();

        return new self(
            [
                'data' => [
                    'id' => $courseSection->getId(),
                    'parent_id' => $courseSection->getAttribute('parent_id'),
                    'author_id' => $courseSection->getAttribute('author_id'),
                    'title' => $courseSection->getAttribute('title'),
                    'description' => $courseSection->getAttribute('description'),
                    'admin_notes' => $courseSection->getAttribute('admin_notes'),
                    'sort_order' => $courseSection->getAttribute('sort_order'),
                    'pass_score' => $courseSection->getAttribute('pass_score'),
                    'finish_course_on_fail' => $courseSection->getAttribute('finish_course_on_fail'),
                    'show_results' => $courseSection->getAttribute('show_results'),
                    'sequential_passage' => $courseSection->getAttribute('sequential_passage'),
                ]
            ]
        );
    }
}

<?php
declare(strict_types=1);

namespace Modules\Course\Http\Responses;

use Illuminate\Http\JsonResponse;
use Modules\Course\Entities\CourseSection;

/**
 * @OA\Schema(
 *   schema="Course.SectionDataResponse",
 *   type="object",
 *   @OA\Property(property="title", type="string", description="Название секции", example="секция 1"),
 *   @OA\Property(property="description", type="string", description="описание секции", example=""),
 *   @OA\Property(property="admin_notes", type="string", description="заметки модератора", example=""),
 *   @OA\Property(property="author_id", type="integer", description="ID пользователя", example="10"),
 *   @OA\Property(property="entity_id", type="integer", description="ID сущности", example="100"),
 *   @OA\Property(property="parent_id", type="integer", description="ID родительской секции", example="100"),
 *   @OA\Property(property="sort_order", type="integer", description="Порядок сортировки", example="100"),
 *   @OA\Property(property="pass_score", type="integer", description="Баллы необходимые для прохождения секции", example="100"),
 *   @OA\Property(property="finish_course_on_fail", type="boolean", description="завершить курс при ошибки прохождения", example="false"),
 *   @OA\Property(property="show_results", type="boolean", description="показывать результаты прохождения", example="false"),
 *   @OA\Property(property="sequential_passage", type="boolean", description="последовательное прохождение", example="false"),
 * )
 */
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

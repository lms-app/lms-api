<?php
declare(strict_types=1);

namespace Modules\Course\Http\Responses;

use Illuminate\Http\JsonResponse;
use Modules\Course\Entities\Course;

/**
 * @OA\Schema(
 *   schema="Course.CatalogStudent",
 *   type="object",
 *   @OA\Property(property="title", type="string", description="Название курса", example="Курс по космонавтике"),
 *   @OA\Property(property="status", type="string", description="Статус курса (открытый, закрытый, ограниченный)", example="open"),
 *   @OA\Property(property="short_description", type="string", description="Краткое описание курса", example=""),
 *   @OA\Property(property="description", type="string", description="Полное описание курса", example=""),
 *   @OA\Property(property="author_id", type="integer", description="ID пользователя", example="10"),
 *   @OA\Property(property="folder_id", type="integer", description="ID папки, по умолчанию null", example="100"),
 * )
 */
final class CourseCatalogStudentResponse extends JsonResponse
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

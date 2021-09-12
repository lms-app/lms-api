<?php
declare(strict_types=1);

namespace Modules\Course\Http\Responses\Element;

use Illuminate\Http\JsonResponse;
use Modules\Course\Entities\CourseElement;

/**
 * @OA\Schema(
 *   schema="Course.SectionElementDataResponse",
 *   type="object",
 *   @OA\Property(property="file_id", type="integer", description="ID файла", example="секция 1"),
 *   @OA\Property(property="title", type="string", description="Название элемента", example="секция 1"),
 *   @OA\Property(property="description", type="string", description="описание элемента", example=""),
 *   @OA\Property(property="author_id", type="integer", description="ID пользователя", example="10"),
 *   @OA\Property(property="sort_order", type="integer", description="Порядок сортировки", example="100"),
 *   @OA\Property(property="type", type="string", description="тип элемента", example="text"),
 *   @OA\Property(property="body", type="string", description="тело элемента", example="Тело элемента"),
 *   @OA\Property(property="attempt_count", type="integer", description="количество попыток прохождения элемента", example="3"),
 *   @OA\Property(property="pass_score", type="integer", description="количество баллов за прохождение элемента", example="10"),
 * )
 */
final class CourseElementDataResponse extends JsonResponse
{
    public static function get(CourseElement $courseElement):self
    {
        return new self(
            [
                'data' => [
                    'id' => $courseElement->getId(),
                    'section_id' => $courseElement->getSectionId(),
                    'author_id' => $courseElement->getAuthorId(),
                    'file_id' => $courseElement->getFileId(),
                    'sort_order' => $courseElement->getAttribute('sort_order'),
                    'type' => $courseElement->getAttribute('type'),
                    'title' => $courseElement->getAttribute('title'),
                    'description' => $courseElement->getAttribute('description'),
                    'body' => $courseElement->getAttribute('body'),
                    'attempt_count' => $courseElement->getAttribute('attempt_count'),
                    'pass_score' => $courseElement->getAttribute('pass_score'),
                ]
            ]
        );
    }
}

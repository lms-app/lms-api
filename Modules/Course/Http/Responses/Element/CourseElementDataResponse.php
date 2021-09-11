<?php
declare(strict_types=1);

namespace Modules\Course\Http\Responses\Element;

use Illuminate\Http\JsonResponse;
use Modules\Course\Entities\CourseElement;

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

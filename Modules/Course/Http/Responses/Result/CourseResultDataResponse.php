<?php
declare(strict_types=1);

namespace Modules\Course\Http\Responses\Result;


use Illuminate\Http\JsonResponse;
use Modules\Course\Entities\CourseResult;

final class CourseResultDataResponse extends JsonResponse
{
    public static function get(CourseResult $courseResult):self
    {
        return new self(
            [
                'data' => [

                ]
            ]
        );
    }
}

<?php
declare(strict_types=1);

namespace Modules\Course\Services;

use Modules\Course\Entities\CourseResult;
use Modules\Course\Http\Requests\Result\CourseResultRequest;

interface CourseResultServiceInterface
{
    public function finish(CourseResultRequest $courseResultRequest):CourseResult;
}

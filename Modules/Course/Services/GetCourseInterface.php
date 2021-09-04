<?php

namespace Modules\Course\Services;

use Modules\Course\Http\Requests\CreateCourseRequest;
use Modules\Entity\Entities\Entity;

interface GetCourseInterface
{
    public function getCourseById(int $courseId):Entity;
}

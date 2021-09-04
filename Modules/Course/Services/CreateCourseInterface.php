<?php

namespace Modules\Course\Services;

use Modules\Course\Http\Requests\CreateCourseRequest;
use Modules\Entity\Entities\Entity;

interface CreateCourseInterface
{
    public function createCourse(CreateCourseRequest $createCourseRequest):Entity;
}

<?php
declare (strict_types=1);

namespace Modules\Course\Traits;


trait GetCourseTrait
{
    public function getCourseId():int
    {
        return (int) $this->course_id;
    }
}

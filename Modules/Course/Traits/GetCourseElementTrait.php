<?php
declare (strict_types=1);

namespace Modules\Course\Traits;


use Modules\Course\Entities\CourseElement;
use Modules\Course\Entities\CourseSection;

trait GetCourseElementTrait
{
    public function getElementId():int
    {
        return (int) $this->element_id;
    }

    public function getElementById(int $elementId):CourseElement
    {
        return CourseElement::query()
            ->where('id', '=', $elementId)
            ->first();
    }
}

<?php
declare (strict_types=1);

namespace Modules\Course\Traits;


trait GetCourseSectionIdTrait
{
    public function getSectionId():int
    {
        return (int) $this->section_id;
    }
}

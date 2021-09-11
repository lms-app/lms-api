<?php
declare (strict_types=1);

namespace Modules\Course\Traits;


use Modules\Course\Entities\CourseSection;

trait GetCourseSectionTrait
{
    public function getSectionId():int
    {
        return (int) $this->section_id;
    }

    public function getParentSectionId():?int
    {
        if ($this->parent_id === null) {
            return null;
        }

        return (int) $this->parent_id;
    }

    public function getSectionById(int $sectionId):CourseSection
    {
        return CourseSection::query()
            ->where('id', '=', $sectionId)
            ->first();
    }
}

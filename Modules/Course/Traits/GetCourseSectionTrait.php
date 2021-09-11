<?php
declare (strict_types=1);

namespace Modules\Course\Traits;

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

    public function hasParentId():bool
    {
        return $this->parent_id !== null;
    }
}

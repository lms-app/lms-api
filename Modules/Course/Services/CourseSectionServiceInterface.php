<?php
declare(strict_types=1);

namespace Modules\Course\Services;

use Modules\Course\Entities\CourseSection;

interface CourseSectionServiceInterface
{
    public function getSectionById(int $sectionId):CourseSection;
    public function createSection(array $createCourseData):CourseSection;
    public function updateSection(int $sectionId, array $updateData):CourseSection;
    public function deleteSections(int ...$sectionIds):void;
}

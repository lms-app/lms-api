<?php
declare(strict_types=1);


namespace Modules\Course\Services;

use Modules\Course\Entities\CourseSection;

final class CourseSectionService implements CourseSectionServiceInterface
{
    public function getSectionById(int $sectionId): CourseSection
    {
        return CourseSection::getById($sectionId);
    }

    public function createSection(array $createCourseData): CourseSection
    {
        return CourseSection::query()
            ->create(
            $createCourseData
        );
    }

    public function updateSection(CourseSection $courseSection, array $updateData): CourseSection
    {
        $courseSection->update($updateData);
        return $courseSection;
    }

    public function deleteSections(int ...$sectionIds): void
    {
        CourseSection::query()
            ->whereIn('id', $sectionIds)
            ->delete();
    }
}

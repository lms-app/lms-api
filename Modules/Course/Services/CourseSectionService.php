<?php
declare(strict_types=1);


namespace Modules\Course\Services;

use Modules\Course\Entities\CourseSection;

final class CourseSectionService implements CourseSectionServiceInterface
{
    public function getSectionById(int $sectionId): CourseSection
    {
        // TODO: Implement getSectionById() method.
    }

    public function createSection(array $createCourseData): CourseSection
    {
        return CourseSection::query()
            ->create(
            $createCourseData
        );
    }

    public function updateSection(int $sectionId, array $updateData): CourseSection
    {
        // TODO: Implement updateSection() method.
    }

    public function deleteSections(int ...$sectionIds): void
    {
        // TODO: Implement deleteSections() method.
    }
}

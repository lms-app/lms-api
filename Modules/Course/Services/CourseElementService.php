<?php
declare(strict_types=1);


namespace Modules\Course\Services;

use Modules\Course\Entities\CourseElement;

final class CourseElementService implements CourseElementServiceInterface
{
    public function getElementById(int $elementId): CourseElement
    {
        // TODO: Implement getElementById() method.
    }

    public function createElement(array $createCourseData): CourseElement
    {
        // TODO: Implement createElement() method.
    }

    public function updateElement(int $elementId, array $updateData): CourseElement
    {
        // TODO: Implement updateElement() method.
    }

    public function deleteElements(int ...$elementIds): void
    {
        // TODO: Implement deleteElements() method.
    }
}

<?php
declare(strict_types=1);


namespace Modules\Course\Services;

use Modules\Course\Entities\CourseElement;

final class CourseElementService implements CourseElementServiceInterface
{
    public function getElementById(int $elementId): CourseElement
    {
        return CourseElement::getById($elementId);
    }

    public function createElement(array $createData): CourseElement
    {
        return CourseElement::query()
            ->create($createData);
    }

    public function updateElement(CourseElement $element, array $updateData): CourseElement
    {
        $element->update($updateData);
        return $element;
    }

    public function deleteElements(int ...$elementIds): void
    {
        CourseElement::query()
            ->whereIn('id', $elementIds)
            ->delete();
    }
}

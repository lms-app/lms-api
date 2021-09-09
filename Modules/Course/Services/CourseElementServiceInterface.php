<?php
declare(strict_types=1);

namespace Modules\Course\Services;

use Modules\Course\Entities\CourseElement;

interface CourseElementServiceInterface
{
    public function getElementById(int $elementId):CourseElement;
    public function createElement(array $createCourseData):CourseElement;
    public function updateElement(int $elementId, array $updateData):CourseElement;
    public function deleteElements(int ...$elementIds):void;
}

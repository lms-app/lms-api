<?php
declare(strict_types=1);

namespace Modules\Course\Services;

use Modules\Course\Entities\Course;
use Modules\Entity\Entities\Entity;
use Throwable;

interface CourseServiceInterface
{
    public function getCourseById(int $courseId):Course;

    /**
     * @param array $createCourseData
     * @return Course
     * @throws Throwable
     */
    public function createCourse(array $createCourseData):Course;
    public function updateCourse(int $courseId, array $updateData):Course;
    public function deleteCourse(int $courseId):void;
}

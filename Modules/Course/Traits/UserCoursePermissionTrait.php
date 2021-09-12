<?php
declare (strict_types=1);

namespace Modules\Course\Traits;

use Modules\Course\Entities\Course;
use Modules\Course\ValueObjects\CoursePermission;
use Modules\Entity\Entities\Entity;
use Modules\Course\ValueObjects\CourseFolderPermission;

trait UserCoursePermissionTrait
{
    public function canSeeCourseAsStudent(Course $entity):bool
    {
        return $this->hasPermissionTo(CoursePermission::SEE_AS_STUDENT);
    }

    public function canSeeCourseAsEditor(Course $course):bool
    {
        if (!$course->isInFolder()) {
            if ($this->hasPermissionTo(CoursePermission::SEE_AS_ADMINISTRATOR)) {
                return true;
            }

            if ($this->hasPermissionTo(CoursePermission::SEE_AS_MODERATOR)) {
                return $this->isModelAuthor($course);
            }
        }

        if ($course->isInFolder()) {
            if ($this->hasPermissionTo(CourseFolderPermission::SEE_AS_ADMINISTRATOR)
                && $this->hasAnyPermission(
                    [
                        CoursePermission::SEE_AS_ADMINISTRATOR,
                        CoursePermission::SEE_AS_MODERATOR
                    ]
                )
            ) {
                return true;
            }

            if ($this->hasPermissionTo(CourseFolderPermission::SEE_AS_MODERATOR)
                && $this->hasAnyPermission(
                    [
                        CoursePermission::SEE_AS_ADMINISTRATOR,
                        CoursePermission::SEE_AS_MODERATOR
                    ]
                )
            ){
                return $this->isModelAuthor($course->getFolder());
            }
        }
        return false;
    }

    public function canDeleteCourse(Course $course):bool
    {
        if (!$course->isInFolder()) {
            if ($this->hasPermissionTo(CoursePermission::DELETE_AS_ADMINISTRATOR)) {
                return true;
            }

            if ($this->hasPermissionTo(CoursePermission::DELETE_AS_MODERATOR)) {
                return $this->isModelAuthor($course);
            }
        }

        if ($course->isInFolder()) {
            if ($this->hasPermissionTo(CourseFolderPermission::SEE_AS_ADMINISTRATOR)
                && $this->hasAnyPermission(
                    [
                        CoursePermission::DELETE_AS_MODERATOR,
                        CoursePermission::DELETE_AS_ADMINISTRATOR
                    ]
                )
            ) {
                return true;
            }

            if ($this->hasPermissionTo(CourseFolderPermission::SEE_AS_MODERATOR)
                && $this->hasAnyPermission(
                    [
                        CoursePermission::DELETE_AS_MODERATOR,
                        CoursePermission::DELETE_AS_ADMINISTRATOR
                    ]
                )
            ){
                return $this->isModelAuthor($course->getFolder());
            }
        }
        return false;
    }

    public function canUpdateCourse(Course $course):bool
    {
        if (!$course->isInFolder()) {
            if ($this->hasPermissionTo(CoursePermission::EDIT_AS_ADMINISTRATOR)) {
                return true;
            }

            if ($this->hasPermissionTo(CoursePermission::EDIT_AS_MODERATOR)) {
                return $this->isModelAuthor($course);
            }
        }

        if ($course->isInFolder()) {
            if ($this->hasPermissionTo(CourseFolderPermission::SEE_AS_ADMINISTRATOR)
                && $this->hasAnyPermission(
                    [
                        CoursePermission::EDIT_AS_MODERATOR,
                        CoursePermission::EDIT_AS_ADMINISTRATOR
                    ]
                )
            ) {
                return true;
            }

            if ($this->hasPermissionTo(CourseFolderPermission::SEE_AS_MODERATOR)
                && $this->hasAnyPermission(
                    [
                        CoursePermission::EDIT_AS_MODERATOR,
                        CoursePermission::EDIT_AS_ADMINISTRATOR
                    ]
                )
            ){
                return $this->isModelAuthor($course->getFolder());
            }
        }
        return false;
    }

    public function canCreateCourse():bool
    {
        return $this->hasPermissionTo(CoursePermission::CREATE);
    }

    public function canTakeCourse():bool
    {
        return $this->hasPermissionTo(CoursePermission::PASS_AS_STUDENT);
    }
}

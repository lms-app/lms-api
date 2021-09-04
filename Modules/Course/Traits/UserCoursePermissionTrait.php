<?php
declare (strict_types=1);

namespace Modules\Course\Traits;

use Modules\Course\ValueObjects\CoursePermission;
use Modules\Entity\Entities\Entity;
use Modules\Course\ValueObjects\CourseFolderPermission;

trait UserCoursePermissionTrait
{
    public function canSeeCourseAsStudent(Entity $entity):bool
    {
        return $this->hasPermissionTo(CoursePermission::SEE_AS_STUDENT);
    }

    public function canSeeCourseAsEditor(Entity $entity):bool
    {
        if (!$entity->isInFolder()) {
            if ($this->hasPermissionTo(CoursePermission::SEE_AS_ADMINISTRATOR)) {
                return true;
            }

            if ($this->hasPermissionTo(CoursePermission::SEE_AS_MODERATOR)) {
                return $this->isModelAuthor($entity);
            }
        }

        if ($entity->isInFolder()) {
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
                return $this->isModelAuthor($entity->getFolder());
            }
        }
        return false;
    }

    public function canDeleteCourse(Entity $entity):bool
    {
        if (!$entity->isInFolder()) {
            if ($this->hasPermissionTo(CoursePermission::DELETE_AS_ADMINISTRATOR)) {
                return true;
            }

            if ($this->hasPermissionTo(CoursePermission::DELETE_AS_MODERATOR)) {
                return $this->isModelAuthor($entity);
            }
        }

        if ($entity->isInFolder()) {
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
                return $this->isModelAuthor($entity->getFolder());
            }
        }
        return false;
    }

    public function canUpdateCourse(Entity $entity):bool
    {
        if (!$entity->isInFolder()) {
            if ($this->hasPermissionTo(CoursePermission::EDIT_AS_ADMINISTRATOR)) {
                return true;
            }

            if ($this->hasPermissionTo(CoursePermission::EDIT_AS_MODERATOR)) {
                return $this->isModelAuthor($entity);
            }
        }

        if ($entity->isInFolder()) {
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
                return $this->isModelAuthor($entity->getFolder());
            }
        }
        return false;
    }

    public function canCreateCourse():bool
    {
        return $this->hasPermissionTo(CoursePermission::CREATE);
    }
}

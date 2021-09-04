<?php
declare(strict_types=1);


namespace Modules\Course\Services;

use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Entity\Entities\Entity;
use Modules\Entity\Services\EntityServiceInterface;
use Throwable;

final class CourseService implements CourseServiceInterface
{
    private EntityServiceInterface $entityService;

    public function __construct(EntityServiceInterface $entityService)
    {
        $this->entityService = $entityService;
    }

    public function createCourse(array $createCourseData): Course
    {
        DB::beginTransaction();
        try {
            $this->entityService->createEntity($createCourseData);

            /** @var Course $course */
            $course = Course::query()->create($createCourseData);
            DB::commit();
            return $course;
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getCourseById(int $courseId): Course
    {
        return Course::query()->where('entity_id', '=', $courseId)->firstOrFail();
    }

    public function deleteCourse(int $courseId): void
    {
        $this->entityService->deleteEntity(
            $this->getCourseById($courseId)
                ->getEntity()
        );
    }

    public function updateCourse(int $courseId, array $createCourseData): Entity
    {
        return $this->entityService->updateEntity(
            $this->getCourseById(
                $courseId
            ),
            $createCourseData
        );
    }
}

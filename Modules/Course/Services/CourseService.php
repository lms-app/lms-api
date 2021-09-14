<?php
declare(strict_types=1);


namespace Modules\Course\Services;

use Illuminate\Support\Facades\DB;
use Modules\Appointment\Entities\Appointment;
use Modules\Appointment\Exceptions\AppointmentException;
use Modules\Appointment\Services\AppointmentServiceInterface;
use Modules\Appointment\ValueObjects\AppointmentStatus;
use Modules\Course\Entities\Course;
use Modules\Entity\Services\EntityServiceInterface;
use Modules\User\Entities\User;
use Throwable;

final class CourseService implements CourseServiceInterface
{
    private EntityServiceInterface $entityService;
    private AppointmentServiceInterface $appointmentService;

    public function __construct(
        EntityServiceInterface $entityService,
        AppointmentServiceInterface $appointmentService
    )
    {
        $this->entityService = $entityService;
        $this->appointmentService = $appointmentService;
    }

    public function createCourse(array $createCourseData): Course
    {
        DB::beginTransaction();
        try {
            $entity = $this->entityService->createEntity($createCourseData);
            $createCourseData['entity_id'] = $entity->getAttribute('id');

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

    /**
     * @throws Throwable
     */
    public function updateCourse(Course $course, array $updateData): Course
    {
        DB::beginTransaction();
        try {
            $course->update($updateData);
            $course->save();

            $this->entityService->updateEntity(
                $course->getEntity(),
                $updateData
            );

            DB::commit();
            return $course;
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param User $user
     * @param Course $course
     * @param array $appointmentData
     * @return Appointment
     * @throws AppointmentException
     */
    public function createAppointment(User $user, Course $course, array $appointmentData): Appointment
    {
        if($this->getActiveAppointment($user)) {
            throw AppointmentException::becauseAppointmentExists();
        }

        return $this->appointmentService->createAppointment($user, $course->getEntity(), $appointmentData);
    }

    public function getAppointmentById(int $appointmentId): Appointment
    {
        return Appointment::getById($appointmentId);
    }

    public function startAppointment(Appointment $appointment): Appointment
    {
        $appointment->changeStatus(
            AppointmentStatus::create(AppointmentStatus::IN_PROGRESS)
        );
        return $appointment;
    }

    public function getActiveAppointment(User $user): ?Appointment
    {
        return Appointment::getActive($user);
    }
}

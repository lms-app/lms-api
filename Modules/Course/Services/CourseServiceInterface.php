<?php
declare(strict_types=1);

namespace Modules\Course\Services;

use Modules\Appointment\Entities\Appointment;
use Modules\Course\Entities\Course;
use Modules\User\Entities\User;
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
    public function updateCourse(Course $course, array $updateData):Course;
    public function deleteCourse(int $courseId):void;
    public function createAppointment(User $user, Course $course, array $appointmentData):Appointment;
    public function getAppointmentById(int $appointmentId):Appointment;
    public function getActiveAppointment(User $user):?Appointment;
    public function startAppointment(Appointment $appointment):Appointment;
}

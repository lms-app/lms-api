<?php
declare(strict_types=1);


namespace Modules\Course\Services;

use Modules\Appointment\Entities\Appointment;
use Modules\Course\Entities\CourseResult;
use Modules\Course\Http\Requests\Result\CourseResultRequest;

final class CourseResultService implements CourseResultServiceInterface
{
    public function finish(CourseResultRequest $courseResultRequest): CourseResult
    {
        $appointment = Appointment::getById($courseResultRequest->getAppointmentId());

        return CourseResult::query()->create(
            [
                'user_id' => $courseResultRequest->getUserModel()->getId(),
                'entity_id' => $appointment->getEntityId(),
                'appointment_id' => $appointment->getId(),
                'section_id' => $courseResultRequest->getCourseSectionId(),
                'element_id' => $courseResultRequest->getCourseElementId(),
                'points' => 0,
                'is_finished' => true,
            ]
        );
    }
}

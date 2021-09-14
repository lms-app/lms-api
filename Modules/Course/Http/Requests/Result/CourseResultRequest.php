<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests\Result;


use App\Requests\FormRequest;
use Modules\Course\Traits\GetCourseAppointmentTrait;

final class CourseResultRequest extends FormRequest
{
    use GetCourseAppointmentTrait;

    public function authorize():bool
    {
        return $this->getUserModel()->canTakeCourse();
    }

    public function getCourseElementId():?int
    {
        return $this->element_id;
    }

    public function getCourseSectionId():?int
    {
        return $this->section_id;
    }

    public function rules():array
    {
        return [
            'appointment_id,required,exists:appointments,id',
        ];
    }
}

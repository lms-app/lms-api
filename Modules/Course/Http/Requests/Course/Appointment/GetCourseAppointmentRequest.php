<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests\Course\Appointment;

use App\Requests\FormRequest;
use Modules\Appointment\Entities\Appointment;
use Modules\Course\Traits\GetCourseAppointmentTrait;

final class GetCourseAppointmentRequest extends FormRequest
{
    use GetCourseAppointmentTrait;

    public function authorize():bool
    {
        return $this->getUserModel()->canTakeCourse() &&
            Appointment::getById(
                $this->getAppointmentId()
            )->getUserId() === $this->getUserModel()->getId();
    }

    public function rules():array
    {
        return [
            'appointment_id,required,exists:appointments,id'
        ];
    }
}

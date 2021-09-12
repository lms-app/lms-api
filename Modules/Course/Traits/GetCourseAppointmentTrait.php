<?php
declare (strict_types=1);

namespace Modules\Course\Traits;


trait GetCourseAppointmentTrait
{
    public function getAppointmentId():int
    {
        return (int) $this->appointment_id;
    }
}

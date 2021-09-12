<?php
declare(strict_types=1);

namespace Modules\Appointment\Services;

use Modules\Appointment\Entities\Appointment;
use Modules\Entity\Entities\Entity;
use Modules\User\Entities\User;

interface AppointmentServiceInterface
{
    public function createAppointment(User $user, Entity $entity, array $appointmentData):Appointment;
}

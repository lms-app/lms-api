<?php
declare(strict_types=1);

namespace Modules\Appointment\Services;

use Modules\Appointment\Entities\Appointment;
use Modules\Entity\Entities\Entity;
use Modules\User\Entities\User;

final class AppointmentService implements AppointmentServiceInterface
{
    public function createAppointment(User $user, Entity $entity, array $appointmentData):Appointment
    {
        $appointmentData = array_merge(
            $appointmentData,
            [
                'user_id' => $user->getId(),
                'entity_id' => $entity->getId(),
            ]
        );

       return Appointment::query()->create($appointmentData);
    }
}

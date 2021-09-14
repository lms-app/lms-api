<?php
declare(strict_types=1);

namespace Modules\Appointment\Exceptions;

use Exception;

final class AppointmentStatusException extends Exception
{
    public static function becauseAppointmentStatusIsNotExists():self
    {
        return new self('Appointment status is not exists');
    }
}

<?php
declare(strict_types=1);

namespace Modules\Appointment\Exceptions;

use Exception;

final class AppointmentException extends Exception
{
    public static function becauseAppointmentExists():self
    {
        return new self('Appointment exists');
    }
}

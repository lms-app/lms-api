<?php
declare(strict_types=1);

namespace Modules\Appointment\ValueObjects;

final class AppointmentStatus
{
    public const ASSIGNED = 'assigned';
    public const IN_PROGRESS = 'in_progress';
    public const DONE = 'done';
}

<?php
declare(strict_types=1);

namespace Modules\Appointment\ValueObjects;

use Modules\Appointment\Exceptions\AppointmentStatusException;

final class AppointmentStatus
{
    public const ASSIGNED = 'assigned';
    public const IN_PROGRESS = 'in_progress';
    public const DONE = 'done';

    private const AVAILABLE_STATUSES = [
        self::ASSIGNED,
        self::IN_PROGRESS,
        self::DONE,
    ];
    private string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
        if (!$this->validate()) {
            throw AppointmentStatusException::becauseAppointmentStatusIsNotExists();
        }
    }

    public static function create(string $status):self
    {
        return new self($status);
    }

    private function validate():bool
    {
        return in_array($this->status, self::AVAILABLE_STATUSES, true);
    }

    public function __toString():string
    {
        return $this->status;
    }
}

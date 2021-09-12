<?php
declare(strict_types=1);

namespace Modules\Appointment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

final class AppointmentFactory extends Factory
{
    protected $model = \Modules\Appointment\Entities\Appointment::class;

    public function definition()
    {
        return [
            //
        ];
    }
}


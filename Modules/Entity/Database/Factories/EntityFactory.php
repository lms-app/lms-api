<?php
declare(strict_types=1);

namespace Modules\Entity\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Entity\ValueObjects\EntityStatus;

final class EntityFactory extends Factory
{
    protected $model = \Modules\Entity\Entities\Entity::class;

    public function definition()
    {
        return [
            'status' => EntityStatus::STATUS_OPEN,
            'title' => $this->faker->name(),
        ];
    }
}


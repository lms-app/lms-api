<?php
declare(strict_types=1);

namespace Modules\Test\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

final class TestFactory extends Factory
{
    protected $model = \Modules\Test\Entities\Test::class;

    public function definition()
    {
        return [
            //
        ];
    }
}


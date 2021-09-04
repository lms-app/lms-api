<?php
declare(strict_types=1);

namespace Modules\Course\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

final class CoursesFactory extends Factory
{
    protected $model = \Modules\Course\Entities\Course::class;

    public function definition():array
    {
        return [

        ];
    }
}

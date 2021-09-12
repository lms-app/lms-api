<?php
declare(strict_types=1);

namespace Modules\Course\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

final class CourseSectionFactory extends Factory
{
    protected $model = \Modules\Course\Entities\CourseSection::class;

    public function definition()
    {
        return [
            'title' => 'some title'
        ];
    }
}


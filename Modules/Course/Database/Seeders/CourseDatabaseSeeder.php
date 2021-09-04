<?php

namespace Modules\Course\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Course\Entities\Course;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;
use Modules\User\Entities\User;

class CourseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $author = User::factory()->create();
        $entity = Entity::factory()->create(
            [
                'entity_type' => EntityType::TYPE_COURSE,
                'author_id' => $author->getAttribute('id'),
            ]
        );
        Course::factory()->create(
            [
                'entity_id' => $entity->getAttribute('id'),
            ]
        );
    }
}

<?php
declare(strict_types=1);


namespace Modules\Course\Services;


use Illuminate\Support\Collection;
use Modules\Course\Entities\Course;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;

final class CourseCatalogService implements CourseCatalogInterface
{
    public function getStudentCatalog(): Collection
    {
        /** @var Course[] $courses */
        $courses = Course::query()
            ->where('entity_type', '=', EntityType::TYPE_COURSE)
            ->join('entities', 'entities.id', 'courses.entity_id')
            ->whereNull('entities.deleted_at')
            ->get();

        $result = [];

        foreach ($courses as $course) {
            $entity = $course->getEntity();
            $result[] = [
                'object' => $entity->getEntityType()->getObject(),
                'id' => $entity->getAttribute('id'),
                'title' => $entity->getAttribute('title'),
                'status' => $entity->getEntityStatus()->__toString(),
                'sections' => [],
                'in_catalog' => false,
                'author_id' => $entity->getAuthorId(),
                'cover' => [
                    'file' => null,
                    'knowledge' => null,
                ],
                'created_at' => $entity->getCreatedAt(),
            ];
        }

        return collect($result);
    }

    public function getModeratorCatalog(): Collection
    {
        /** @var Course[] $courses */
        $courses = Course::query()
            ->where('entity_type', '=', EntityType::TYPE_COURSE)
            ->join('entities', 'entities.id', 'courses.entity_id')
            ->whereNull('entities.deleted_at')
            ->get();

        $result = [];

        foreach ($courses as $course) {
            $entity = $course->getEntity();
            $result[] = [
                'object' => $entity->getEntityType()->getObject(),
                'id' => $entity->getAttribute('id'),
                'title' => $entity->getAttribute('title'),
                'status' => $entity->getEntityStatus()->__toString(),
                'in_catalog' => false,
                'author_id' => $entity->getAuthorId(),
                'cover' => [
                    'file' => null,
                    'knowledge' => null,
                ],
                'created_at' => $entity->getCreatedAt(),
            ];
        }

        return collect($result);
    }
}

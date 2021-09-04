<?php
declare(strict_types=1);

namespace Modules\Entity\Services;

use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;

final class EntityService implements EntityServiceInterface
{
    public function createEntity(array $createEntityData): Entity
    {
        return Entity::query()
            ->create(
                $createEntityData
            );
    }

    public function getEntityById(int $entityId): Entity
    {
        return Entity::query()
            ->where('id', '=', $entityId)
            ->firstOrFail();
    }

    public function updateEntity(Entity $entity, array $updateData): Entity
    {
        $entity->update($updateData);
        return $entity;
    }

    public function deleteEntity(Entity $entity): void
    {
        $entity->delete();
        $entity->save();
    }

    public function getEntityByType(int $entityId, EntityType $entityType): Entity
    {
        return Entity::query()
            ->where('id', '=', $entityId)
            ->where('entity_type', '=', $entityType)
            ->firstOrFail();
    }
}

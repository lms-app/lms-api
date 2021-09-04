<?php
declare(strict_types=1);

namespace Modules\Entity\Services;

use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;

interface EntityServiceInterface
{
    public function getEntityById(int $entityId): Entity;
    public function getEntityByType(int $entityId, EntityType $entityType): Entity;
    public function createEntity(array $createEntityData): Entity;
    public function updateEntity(Entity $entity, array $updateData): Entity;
    public function deleteEntity(Entity $entity):void;
}

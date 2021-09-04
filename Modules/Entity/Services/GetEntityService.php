<?php
declare(strict_types=1);

namespace Modules\Entity\Services;

use Modules\Entity\Entities\Entity;

final class GetEntityService implements GetEntityServiceInterface
{
    public function getEntityById(int $entityId): Entity
    {
        return Entity::query()
            ->where('id', '=', $entityId)
            ->firstOrFail();
    }
}

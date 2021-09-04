<?php
declare(strict_types=1);

namespace Modules\Entity\Services;

use Modules\Entity\Entities\Entity;

interface GetEntityServiceInterface
{
    public function getEntityById(int $entityId): Entity;
}

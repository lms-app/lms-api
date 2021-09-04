<?php
declare(strict_types=1);


namespace Modules\Course\Services;


use Modules\Entity\Entities\Entity;
use Modules\Entity\Services\GetEntityServiceInterface;

final class GetCourseService implements GetCourseInterface
{
    private GetEntityServiceInterface $getElementService;

    public function __construct(GetEntityServiceInterface $getElementService)
    {
        $this->getElementService = $getElementService;
    }

    public function getCourseById(int $courseId): Entity
    {
        return $this->getElementService->getEntityById($courseId);
    }
}

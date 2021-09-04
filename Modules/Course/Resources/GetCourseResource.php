<?php
declare(strict_types=1);

namespace Modules\Course\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Entity\Entities\Entity;

/**
 * @property Entity $resource
 */
final class GetCourseResource extends JsonResource
{
    public function toArray($request)
    {
        return $this->resource->jsonSerialize();
    }
}

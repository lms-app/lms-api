<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests;

use App\Requests\FormRequest;
use App\Traits\GetIdTrait;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;

/**
 * @property int $id
 */
final class DeleteCourseByIdRequest  extends FormRequest
{
    use GetIdTrait;

    public function authorize():bool
    {
        return $this->user()->canDeleteCourse(
            Entity::getEntityByType(
                $this->getId(),
                EntityType::create(
                    EntityType::TYPE_COURSE
                )
            )
        );
    }
}

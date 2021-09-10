<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests;

use App\Requests\FormRequest;
use App\Traits\GetIdTrait;
use Modules\Course\Traits\GetCourseSectionIdTrait;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;

/**
 * @property int $id
 * @property int $section_id
 */
final class DeleteCourseSectionByIdRequest  extends FormRequest
{
    use GetIdTrait;
    use GetCourseSectionIdTrait;

    public function authorize():bool
    {
        return $this->user()->canUpdateCourse(
            Entity::getEntityByType(
                $this->getId(),
                EntityType::create(
                    EntityType::TYPE_COURSE
                )
            )
        );
    }

    public function rules(): array
    {
        return [
            'id,required,exists:entities,id',
            'section_id,required,exists:course_sections,id',
        ];
    }
}

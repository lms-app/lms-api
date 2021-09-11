<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests;

use App\Requests\FormRequest;
use Modules\Course\Traits\GetCourseSectionTrait;

/**
 * @property int $id
 * @property int $section_id
 */
final class UpdateCourseSectionByIdRequest  extends FormRequest
{
    use GetCourseSectionTrait;

    public function authorize():bool
    {
        $courseSection = $this->getSectionById($this->getSectionId());

        if ($this->getParentSectionId() !== null) {
            $parentSection = $this->getSectionById(
                $this->getParentSectionId()
            );

            if(!$parentSection->getEntity()->equals($courseSection->getEntity())) {
                return false;
            }
        }

        return $this->user()->canUpdateCourse(
            $courseSection->getEntity()
        );
    }

    public function rules(): array
    {
        return [
            'section_id,required,exists:course_sections,id',
            'parent_id,exists:course_sections,id',
        ];
    }
}

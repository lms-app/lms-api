<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests\Section;

use App\Requests\FormRequest;
use Modules\Course\Entities\CourseSection;
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
        $courseSection = CourseSection::getById($this->getSectionId());

        if ($this->hasParentId()) {
            $parentSection = CourseSection::getById($this->getParentSectionId());

            if(!$parentSection->getEntity()->equals($courseSection->getEntity())) {
                return false;
            }
        }

        return $this->getUserModel()->canUpdateCourse(
            $courseSection->getCourse()
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

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
final class DeleteCourseSectionByIdRequest  extends FormRequest
{
    use GetCourseSectionTrait;

    public function authorize():bool
    {
        return $this->user()->canUpdateCourse(
            CourseSection::getById($this->getSectionId())
                ->getCourse()
        );
    }

    public function rules(): array
    {
        return [
            'section_id,required,exists:course_sections,id',
        ];
    }
}

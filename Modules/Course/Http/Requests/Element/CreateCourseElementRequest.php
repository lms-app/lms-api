<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests\Element;

use App\Requests\FormRequest;
use Modules\Course\Entities\CourseSection;
use Modules\Course\Traits\GetCourseSectionTrait;

/**
 * @property int $section_id
 */
final class CreateCourseElementRequest extends FormRequest
{
    use GetCourseSectionTrait;

    public function authorize():bool
    {
        try {
            return $this->getUserModel()
                ->canUpdateCourse(
                    CourseSection::getById($this->getSectionId())->getCourse()
                );
        } catch (\Throwable $exception) {
            return false;
        }
    }

    public function rules():array
    {
        return [
            'section_id,required,exists:course_sections,id',
            'title,required',
        ];
    }
}

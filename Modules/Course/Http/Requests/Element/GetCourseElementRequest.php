<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests\Element;

use App\Requests\FormRequest;
use Modules\Course\Entities\CourseElement;
use Modules\Course\Entities\CourseSection;
use Modules\Course\Traits\GetCourseElementTrait;
use Modules\Course\Traits\GetCourseSectionTrait;

/**
 * @property int $element_id
 */
final class GetCourseElementRequest extends FormRequest
{
    use GetCourseElementTrait;
    use GetCourseSectionTrait;

    public function authorize():bool
    {
        try {
            return $this->getUserModel()
                ->canSeeCourseAsEditor(
                    CourseElement::getById($this->getElementId())->getCourse()
                );
        } catch (\Throwable $exception) {
            return false;
        }
    }

    public function rules():array
    {
        return [
            'element_id,required,exists:course_elements,id',
        ];
    }
}

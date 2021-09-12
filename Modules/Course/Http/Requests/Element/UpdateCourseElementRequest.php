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
final class UpdateCourseElementRequest extends FormRequest
{
    use GetCourseElementTrait;
    use GetCourseSectionTrait;

    public function authorize():bool
    {
        try {
            $courseElement = CourseElement::getById($this->getElementId());

            if ($this->hasSectionId()
                && !$this->getUserModel()->canUpdateCourse(CourseSection::getById($this->getSectionId())->getCourse())) {
                return false;
            }

            return $this->getUserModel()
                ->canUpdateCourse(
                    $courseElement->getCourse()
                );
        } catch (\Throwable $exception) {
            return false;
        }
    }

    public function rules():array
    {
        return [
            'element_id,required,exists:course_elements,id',
            'title,required',
        ];
    }
}

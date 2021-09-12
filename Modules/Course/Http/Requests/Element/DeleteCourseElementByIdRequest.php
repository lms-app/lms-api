<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests\Element;

use App\Requests\FormRequest;
use Modules\Course\Entities\CourseElement;
use Modules\Course\Traits\GetCourseElementTrait;

/**
 * @property int $element_id
 */
final class DeleteCourseElementByIdRequest  extends FormRequest
{
    use GetCourseElementTrait;

    public function authorize():bool
    {
        return $this->user()->canUpdateCourse(
            CourseElement::getById($this->getElementId())->getCourse()
        );
    }

    public function rules(): array
    {
        return [
            'element_id,required,exists:course_elements,id',
        ];
    }
}

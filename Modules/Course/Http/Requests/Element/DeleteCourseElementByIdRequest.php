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
        /** @var CourseElement $courseElement */
        $courseElement = CourseElement::query()
            ->where(
                'id',
                '=',
                $this->getElementById($this->getElementId())
            )
            ->first();
        return $this->user()->canUpdateCourse(
            $courseElement->getSection()->getEntity()
        );
    }

    public function rules(): array
    {
        return [
            'section_id,required,exists:course_sections,id',
        ];
    }
}

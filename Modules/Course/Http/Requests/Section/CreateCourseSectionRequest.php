<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests\Section;

use App\Requests\FormRequest;
use Modules\Course\Entities\Course;
use Modules\Course\Traits\GetCourseTrait;

final class CreateCourseSectionRequest extends FormRequest
{
    use GetCourseTrait;

    public function authorize():bool
    {
        return $this->getUserModel()->canUpdateCourse(Course::getById($this->getCourseId()));
    }

    public function rules():array
    {
        return [
            'id,required,exists:entities,id',
            'title,required',
        ];
    }
}

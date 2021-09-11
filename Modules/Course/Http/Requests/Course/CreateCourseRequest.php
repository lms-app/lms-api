<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests\Course;

use App\Requests\FormRequest;
use Modules\Entity\ValidationRules\EntityStatusRule;

final class CreateCourseRequest extends FormRequest
{
    public function authorize():bool
    {
        return $this->user()->canCreateCourse();
    }

    public function rules():array
    {
        return [
            'status' => ['required', new EntityStatusRule()],
        ];
    }
}

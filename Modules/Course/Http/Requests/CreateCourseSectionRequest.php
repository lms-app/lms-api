<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests;

use App\Requests\FormRequest;
use App\Traits\GetIdTrait;
use Modules\Entity\ValidationRules\EntityStatusRule;

final class CreateCourseSectionRequest extends FormRequest
{
    use GetIdTrait;

    public function authorize():bool
    {
        return $this->user()->canCreateCourse();
    }

    public function rules():array
    {
        return [
            'id,required,exists:entities,id',
            'title,required',
        ];
    }
}

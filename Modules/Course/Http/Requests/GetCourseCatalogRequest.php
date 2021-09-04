<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests;

use App\Requests\FormRequest;
use Modules\Course\ValueObjects\CoursePermission;


final class GetCourseCatalogRequest extends FormRequest
{
    public function authorize():bool
    {
        return $this->user()->hasPermissionTo(CoursePermission::SEE_AS_STUDENT);
    }
}

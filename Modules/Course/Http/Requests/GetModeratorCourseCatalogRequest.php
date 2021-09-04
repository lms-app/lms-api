<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests;

use App\Requests\FormRequest;
use Modules\Course\ValueObjects\CoursePermission;


final class GetModeratorCourseCatalogRequest extends FormRequest
{
    public function authorize():bool
    {
        if ($this->user()->hasPermissionTo(CoursePermission::SEE_AS_ADMINISTRATOR)) {
            return true;
        }

        if ($this->user()->hasPermissionTo(CoursePermission::SEE_AS_MODERATOR)) {
            return true;
        }

        return false;
    }
}

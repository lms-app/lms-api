<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests\Course;

use App\Requests\FormRequest;
use App\Traits\GetIdTrait;
use Modules\Course\Entities\Course;
use Modules\Course\Traits\GetCourseTrait;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;

/**
 * @property int $course_id
 */
final class DeleteCourseByIdRequest  extends FormRequest
{
    use GetCourseTrait;

    public function authorize():bool
    {
        return $this->getUserModel()->canDeleteCourse(
            Course::getById($this->getCourseId())
        );
    }
}

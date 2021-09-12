<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests\Course;

use App\Requests\FormRequest;
use DateTimeImmutable;
use DateTimeInterface;
use Modules\Course\Traits\GetCourseTrait;
use Modules\Entity\ValidationRules\EntityStatusRule;

final class CreateCourseAppointmentRequest extends FormRequest
{
    use GetCourseTrait;

    public function authorize():bool
    {
        return $this->getUserModel()->canTakeCourse();
    }

    public function getDateEnd(): DateTimeInterface
    {
        if ($this->date_end === null) {
            return new DateTimeImmutable('+ 1 month');
        }

        return new DateTimeImmutable($this->date_end);
    }

    public function getAttemptsMax():int
    {
        if ($this->attempts_max === null) {
            return 1;
        }

        return (int) $this->attempts_max;
    }

    public function rules():array
    {
        return [
            'course_id,required,exists:entities,id'
        ];
    }
}

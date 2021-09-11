<?php
declare(strict_types=1);

namespace Modules\Course\Http\Requests;

use App\Requests\FormRequest;
use App\Traits\GetIdTrait;
use Modules\Course\Entities\CourseSection;
use Modules\Course\Traits\GetCourseSectionIdTrait;
use Modules\Entity\Entities\Entity;
use Modules\Entity\ValueObjects\EntityType;

/**
 * @property int $id
 * @property int $section_id
 */
final class DeleteCourseSectionByIdRequest  extends FormRequest
{
    use GetCourseSectionIdTrait;

    public function authorize():bool
    {
        /** @var CourseSection $courseSection */
        $courseSection = CourseSection::query()
            ->where('id', '=', $this->getSectionId())
            ->first();
        return $this->user()->canUpdateCourse(
            $courseSection->getEntity()
        );
    }

    public function rules(): array
    {
        return [
            'section_id,required,exists:course_sections,id',
        ];
    }
}

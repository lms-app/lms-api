<?php
declare(strict_types=1);

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $user_id
 * @property int $entity_id
 * @property int $appointment_id
 * @property ?int $section_id
 * @property ?int $element_id
 * @property float $points
 * @property boolean $is_finished
 */
final class CourseResult extends Model
{
    use HasFactory;
    use SoftDeletes;

    private static array $courseResult = [];

    protected $fillable = [
        'user_id',
        'entity_id',
        'appointment_id',
        'section_id',
        'element_id',
        'points',
        'is_finished',
    ];

    public function getUserId():int
    {
        return $this->user_id;
    }

    public function getEntityId():int
    {
        return $this->entity_id;
    }

    public function getAppointmentId():int
    {
        return $this->appointment_id;
    }

    public function getSectionId():?int
    {
        return $this->section_id;
    }

    public function getElementId():?int
    {
        return $this->element_id;
    }

    public function getPoints():float
    {
        return $this->points;
    }

    public function isFinished():bool
    {
        return $this->is_finished;
    }

    public static function getById(int $id):self
    {
        if (!isset(self::$courseResult[$id])) {
            self::$courseResult[$id] = self::query()
                ->where('id', '=', $id)
                ->first();
        }

        return self::$courseResult[$id];
    }

    protected static function newFactory()
    {
        return \Modules\Course\Database\Factories\CourseResultFactory::new();
    }
}

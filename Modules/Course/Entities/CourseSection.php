<?php
declare(strict_types=1);

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Course\Exceptions\CourseSectionException;
use Modules\Entity\Entities\Entity;

/**
 * @property Entity $entity
 */
final class CourseSection extends Model
{
    use HasFactory;

    private static array $courseSections = [];

    protected $fillable = [
        'entity_id',
        'parent_id',
        'sort_order',
        'pass_score',
        'title',
        'description',
        'author_id',
        'admin_notes',
        'finish_course_on_fail',
        'show_results',
        'sequential_passage',
    ];

    public function entity():BelongsTo
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'id');
    }

    public function course():BelongsTo
    {
        return $this->belongsTo(Course::class, 'entity_id', 'entity_id');
    }

    public function getCourse():Course
    {
        return $this->course;
    }

    public function getEntity():Entity
    {
        return $this->entity;
    }

    public function getEntityId():int
    {
        return $this->entity_id;
    }

    public function getId():int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return CourseSection
     * @throws CourseSectionException
     */
    public static function getById(int $id):self
    {
        if (!isset(self::$courseSections[$id])) {
            self::$courseSections[$id] = self::query()
                ->where('id', '=', $id)
                ->first();
        }

        if (self::$courseSections[$id] === null) {
            throw CourseSectionException::becauseSectionIsNotExist();
        }

        return self::$courseSections[$id];
    }

    protected static function newFactory()
    {
        return \Modules\Course\Database\Factories\CourseSectionFactory::new();
    }
}

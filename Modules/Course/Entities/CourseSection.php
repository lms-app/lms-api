<?php
declare(strict_types=1);

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Entity\Entities\Entity;

/**
 * @property Entity $entity
 */
final class CourseSection extends Model
{
    use HasFactory;

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

    protected static function newFactory()
    {
        return \Modules\Course\Database\Factories\CourseSectionFactory::new();
    }
}

<?php
declare(strict_types=1);

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Course\Database\Factories\CoursesFactory;
use Modules\Entity\Entities\Entity;

/**
 * @property Entity $entity
 */
final class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_id',
        'attempts_count',
        'after_finished_view_element_access',
        'section_sequential_passage',
    ];

    public function entity():BelongsTo
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'id');
    }

    public function getEntity():Entity
    {
        return $this->entity;
    }

    protected static function newFactory():CoursesFactory
    {
        return CoursesFactory::new();
    }
}

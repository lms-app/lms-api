<?php
declare(strict_types=1);

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Course\Database\Factories\CoursesFactory;
use Modules\Entity\Entities\Entity;
use Modules\Folder\Entities\Folder;

/**
 * @property Entity $entity
 */
final class Course extends Model
{
    use HasFactory;

    private static array $courses = [];

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

    public function isInFolder():bool
    {
       return $this->getEntity()->isInFolder();
    }

    public function getFolder():?Folder
    {
        return $this->getEntity()->getFolder();
    }

    public function getAuthorId():int
    {
       return $this->getEntity()->getAuthorId();
    }

    public static function getById(int $id):Course
    {
        if (!isset(self::$courses[$id])) {
            self::$courses[$id] = self::query()
                ->where('entity_id', '=', $id)
                ->first();
        }

        return self::$courses[$id];
    }

    protected static function newFactory():CoursesFactory
    {
        return CoursesFactory::new();
    }
}

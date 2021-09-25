<?php
declare(strict_types=1);

namespace Modules\Test\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Course\Entities\Course;
use Modules\Entity\Entities\Entity;
use Modules\Folder\Entities\Folder;
use Modules\Test\Exceptions\TestException;

final class Test extends Model
{
    use HasFactory;
    use SoftDeletes;

    private static array $tests = [];

    protected $fillable = [
        'entity_id',
        'attempts_count',
        'strict_navigation',
        'pass_score',
    ];

    protected static function newFactory()
    {
        return \Modules\Test\Database\Factories\TestFactory::new();
    }

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
        if (!isset(self::$tests[$id])) {
            self::$tests[$id] = self::query()
                ->where('entity_id', '=', $id)
                ->first();
        }

        if (self::$tests[$id] === null) {
            throw TestException::becauseTestIsNotExist();
        }

        return self::$tests[$id];
    }
}

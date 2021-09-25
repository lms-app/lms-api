<?php
declare(strict_types=1);

namespace Modules\Test\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Course\Exceptions\CourseSectionException;
use Modules\Entity\Entities\Entity;

final class TestSection extends Model
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
        'shake_questions',
        'shake_answers',
        'random_selection',
    ];

    private static array $testSections = [];

    public function entity():BelongsTo
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'id');
    }

    public function test():BelongsTo
    {
        return $this->belongsTo(Test::class, 'entity_id', 'entity_id');
    }

    public function getTest():Test
    {
        return $this->test;
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
     * @return TestSection
     * @throws CourseSectionException
     */
    public static function getById(int $id):self
    {
        if (!isset(self::$testSections[$id])) {
            self::$testSections[$id] = self::query()
                ->where('id', '=', $id)
                ->first();
        }

        if (self::$testSections[$id] === null) {
            throw CourseSectionException::becauseSectionIsNotExist();
        }

        return self::$testSections[$id];
    }

    public function equals(TestSection $testSection):bool
    {
        return $this->getId() === $testSection->getId();
    }

    protected static function newFactory()
    {
        return \Modules\Test\Database\Factories\TestSectionFactory::new();
    }
}

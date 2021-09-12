<?php
declare(strict_types=1);

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Course\Exceptions\CourseElementException;
use Modules\Entity\Entities\Entity;

final class CourseElement extends Model
{
    use HasFactory;
    use SoftDeletes;

    private static array $courseElements = [];

    protected $fillable = [
        'section_id',
        'author_id',
        'sort_order',
        'type',
        'title',
        'description',
        'body',
        'file_id',
        'attempt_count',
        'pass_score',
    ];

    public function section():BelongsTo
    {
        return $this->belongsTo(CourseSection::class, 'section_id', 'id');
    }

    public function getSection():CourseSection
    {
        return $this->section;
    }

    public function getId():int
    {
        return $this->id;
    }

    public function getSectionId():int
    {
        return $this->section_id;
    }

    public function getAuthorId():int
    {
        return $this->author_id;
    }

    public function getFileId():?int
    {
        return $this->file_id;
    }

    public function getCourse():Course
    {
        return $this->getSection()->getCourse();
    }

    public static function getById(int $id):self
    {
        if (!isset(self::$courseElements[$id])) {
            self::$courseElements[$id] = self::query()
                ->where('id', '=', $id)
                ->first();
        }

        if (self::$courseElements[$id] === null) {
            throw CourseElementException::becauseCourseElementIsNotExist();
        }

        return self::$courseElements[$id];
    }

    public function equals(CourseElement $courseElement):bool
    {
        return $this->getId() === $courseElement->getId();
    }

    protected static function newFactory()
    {
        return \Modules\Course\Database\Factories\CourseElementFactory::new();
    }
}

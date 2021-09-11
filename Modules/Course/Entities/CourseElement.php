<?php
declare(strict_types=1);

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Entity\Entities\Entity;

final class CourseElement extends Model
{
    use HasFactory;

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

    protected static function newFactory()
    {
        return \Modules\Course\Database\Factories\CourseElementFactory::new();
    }
}

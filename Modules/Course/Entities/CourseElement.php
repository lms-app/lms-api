<?php
declare(strict_types=1);

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected static function newFactory()
    {
        return \Modules\Course\Database\Factories\CourseElementFactory::new();
    }
}

<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseSection extends Model
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

    protected static function newFactory()
    {
        return \Modules\Course\Database\factories\CourseSectionFactory::new();
    }
}

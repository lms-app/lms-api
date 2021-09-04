<?php

namespace Modules\Visibility\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisibilityGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'group_id',
        'entity_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Visibility\Database\Factories\VisibilityGroupFactory::new();
    }
}

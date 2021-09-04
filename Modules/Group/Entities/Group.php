<?php

namespace Modules\Group\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'notes',
        'author_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Group\Database\Factories\GroupFactory::new();
    }
}

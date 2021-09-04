<?php
declare(strict_types=1);

namespace Modules\Group\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class GroupUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Group\Database\Factories\GroupUserFactory::new();
    }
}

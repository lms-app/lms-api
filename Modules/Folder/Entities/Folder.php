<?php
declare(strict_types=1);

namespace Modules\Folder\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Folder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'author_id',
        'entity_type',
        'title',
        'color',
    ];

    public static function getById(int $folderId):Folder
    {
        return Folder::query()
            ->where(
            'id',
            '=',
            $folderId
            )
            ->firstOrFail();
    }

    protected static function newFactory()
    {
        return \Modules\Folder\Database\Factories\FolderFactory::new();
    }
}

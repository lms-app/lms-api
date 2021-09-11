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

    private static array $folders = [];

    protected $fillable = [
        'author_id',
        'entity_type',
        'title',
        'color',
    ];

    public static function getById(int $id):self
    {
        if (!isset(self::$folders[$id])) {
            self::$folders[$id] = self::query()
                ->where('id', '=', $id)
                ->first();
        }

        return self::$folders[$id];
    }

    public function getAuthorId():int
    {
        return $this->author_id;
    }

    protected static function newFactory()
    {
        return \Modules\Folder\Database\Factories\FolderFactory::new();
    }
}

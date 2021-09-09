<?php
declare(strict_types=1);

namespace Modules\File\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_name',
        'file_name',
        'public_path',
        'file_path',
        'mime_type',
        'size',
    ];

    protected static function newFactory()
    {
        return \Modules\File\Database\Factories\FileFactory::new();
    }
}

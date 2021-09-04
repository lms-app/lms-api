<?php
declare(strict_types=1);

namespace Modules\Entity\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Entity\ValueObjects\EntityStatus;
use Modules\Entity\ValueObjects\EntityType;
use Modules\Folder\Entities\Folder;
use Modules\User\Entities\User;

/**
 * @property ?Folder $folder
 */
final class Entity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'status',
        'short_description',
        'entity_type',
        'description',
        'author_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Entity\Database\Factories\EntityFactory::new();
    }

    public static function isUserEntityAuthor(User $user, int $entityId, EntityType $entityType):bool
    {
        return Entity::query()
            ->where('id', '=', $entityId)
            ->where('entity_type', '=', $entityType)
            ->where('author_id', '=', $user->getId())
            ->exists();
    }

    public static function getEntityByType(int $entityId, EntityType $entityType):Entity
    {
        return Entity::query()
            ->where('id', '=', $entityId)
            ->where('entity_type', '=', $entityType)
            ->firstOrFail();
    }

    public function getId():int
    {
        return $this->id;
    }

    public function isInFolder():bool
    {
        return $this->folder_id !== null;
    }

    public function getFolderId():?int
    {
        return $this->folder_id;
    }

    public function folder():HasOne
    {
        return $this->hasOne(Folder::class, 'id', 'folder_id')
            ->where('entity_type', '=', $this->entity_type);
    }

    public function getFolder():?Folder
    {
        return $this->folder;
    }

    public function getEntityType():EntityType
    {
        return EntityType::create($this->entity_type);
    }

    public function getEntityStatus():EntityStatus
    {
        return EntityStatus::create($this->status);
    }

    public function getAuthorId():int
    {
        return $this->author_id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }
}

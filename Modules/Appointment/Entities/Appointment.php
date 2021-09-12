<?php
declare(strict_types=1);

namespace Modules\Appointment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Entity\Entities\Entity;
use Modules\User\Entities\User;

final class Appointment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'entity_id',
        'date_start',
        'date_end',
        'status',
        'attempts_max',
    ];

    public function entity():BelongsTo
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'id');
    }

    public function getEntity():Entity
    {
        return $this->entity;
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getUser():User
    {
        return $this->user;
    }

    protected static function newFactory()
    {
        return \Modules\Appointment\Database\Factories\AppointmentFactory::new();
    }

    public function getId():int
    {
        return $this->id;
    }

    public function getUserId():int
    {
        return $this->user_id;
    }

    public function getEntityId():int
    {
        return $this->entity_id;
    }

    public function getStatus():string
    {
        return $this->status;
    }

    public function getDateStart():string
    {
        return $this->date_start;
    }

    public function getDateEnd():string
    {
        return $this->date_end;
    }

    public function getAttemptsMax():int
    {
        return $this->attempts_max;
    }
}

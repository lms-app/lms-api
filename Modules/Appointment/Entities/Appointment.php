<?php
declare(strict_types=1);

namespace Modules\Appointment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Appointment\Exceptions\AppointmentException;
use Modules\Appointment\ValueObjects\AppointmentStatus;
use Modules\Entity\Entities\Entity;
use Modules\User\Entities\User;

final class Appointment extends Model
{
    use HasFactory;
    use SoftDeletes;

    private static array $appointments = [];

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

    public static function getById(int $id):self
    {
        if (!isset(self::$appointments[$id])) {
            self::$appointments[$id] = self::query()
                ->where('entity_id', '=', $id)
                ->first();
        }

        if (self::$appointments[$id] === null) {
            throw AppointmentException::becauseAppointmentIsNotExists();
        }

        return self::$appointments[$id];
    }

    public static function getActive(User $user):?self
    {
        return self::query()
            ->where('status', '!=', AppointmentStatus::DONE)
            ->where('user_id', '=', $user->getId())
            ->first();
    }

    public function changeStatus(AppointmentStatus $appointmentStatus):void
    {
        $this->setAttribute('status', $appointmentStatus->__toString());
        $this->save();

    }
}

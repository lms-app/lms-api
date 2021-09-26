<?php

namespace App\Models;

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Authentication\ValueObjects\Login;
use Modules\Course\Traits\UserCoursePermissionTrait;
use Modules\User\Exceptions\UserNotFoundException;
use Modules\User\ValueObjects\Email;
use Modules\User\ValueObjects\LoginValueInterface;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 */
final class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
    use UserCoursePermissionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function newFactory()
    {
        return \Modules\User\Database\Factories\UserFactory::new();
    }

    public function getId():int
    {
        return $this->id;
    }

    public function getAuthorId():int
    {
        return $this->id;
    }

    public function isModelAuthor(Model $model):bool
    {
        return $model->getAuthorId() === $this->getAuthorId();
    }

    public function getFullName():string
    {
        return $this->getAttribute('name');
    }

    public function getEmail():string
    {
        return $this->getAttribute('email');
    }

    public function getAboutMe():?string
    {
        return $this->about_me;
    }

    public function getPhone():?string
    {
        return $this->phone;
    }

    public static function findByLogin(LoginValueInterface $login):User
    {
        $userQuery = User::query();

        if ($login instanceof Email) {
            $userQuery = $userQuery
                ->where(
                    'email',
                    '=',
                    $login
                );
        }
        /** @var User $user */
            $user = $userQuery->first();

            if ($user === null){
                throw UserNotFoundException::becauseUserIsNotFoundByLogin();
            }

            return $user;
    }
}

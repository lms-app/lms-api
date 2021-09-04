<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Modules\Authorization\ValueObjects\Role as RoleVO;

final class CreateAppRoles extends Migration
{
    public function up():void
    {
        Role::create(['name' => RoleVO::ADMINISTRATOR]);
        Role::create(['name' => RoleVO::MODERATOR]);
        Role::create(['name' => RoleVO::STUDENT]);
    }

    public function down():void
    {
        Role::query()->where('name', '=', RoleVO::ADMINISTRATOR);
        Role::query()->where('name', '=', RoleVO::MODERATOR);
        Role::query()->where('name', '=', RoleVO::STUDENT);
    }
}

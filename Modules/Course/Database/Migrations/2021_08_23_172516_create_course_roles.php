<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Course\ValueObjects\CoursePermission;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Modules\Authorization\ValueObjects\Role as RoleVO;

final class CreateCourseRoles extends Migration
{
    public function up():void
    {
        Permission::create(['name' => CoursePermission::CREATE]);
        Permission::create(['name' => CoursePermission::SEE_AS_ADMINISTRATOR]);
        Permission::create(['name' => CoursePermission::SEE_AS_MODERATOR]);
        Permission::create(['name' => CoursePermission::EDIT_AS_ADMINISTRATOR]);
        Permission::create(['name' => CoursePermission::EDIT_AS_MODERATOR]);
        Permission::create(['name' => CoursePermission::DELETE_AS_ADMINISTRATOR]);
        Permission::create(['name' => CoursePermission::DELETE_AS_MODERATOR]);
        Permission::create(['name' => CoursePermission::SEE_AS_STUDENT]);
        Permission::create(['name' => CoursePermission::PASS_AS_STUDENT]);

        /** @var Role $administrator */
        $administrator = Role::query()->where('name', '=', RoleVO::ADMINISTRATOR)->first();
        $administrator->givePermissionTo(
            CoursePermission::CREATE,
            CoursePermission::SEE_AS_ADMINISTRATOR,
            CoursePermission::EDIT_AS_ADMINISTRATOR,
            CoursePermission::DELETE_AS_ADMINISTRATOR,
        );
        $administrator->save();

        /** @var Role $moderator */
        $moderator = Role::query()->where('name', '=', RoleVO::MODERATOR)->first();
        $moderator->givePermissionTo(
            CoursePermission::CREATE,
            CoursePermission::SEE_AS_MODERATOR,
            CoursePermission::EDIT_AS_MODERATOR,
            CoursePermission::DELETE_AS_MODERATOR,
        );
        $moderator->save();

        /** @var Role $student */
        $student = Role::query()->where('name', '=', RoleVO::STUDENT)->first();
        $student->givePermissionTo(
            CoursePermission::SEE_AS_STUDENT,
            CoursePermission::PASS_AS_STUDENT
        );
        $student->save();
    }

    public function down():void
    {
        Permission::query()->where('name', '=', CoursePermission::CREATE)->delete();
        Permission::query()->where('name', '=', CoursePermission::SEE_AS_ADMINISTRATOR)->delete();
        Permission::query()->where('name', '=', CoursePermission::SEE_AS_MODERATOR)->delete();
        Permission::query()->where('name', '=', CoursePermission::EDIT_AS_ADMINISTRATOR)->delete();
        Permission::query()->where('name', '=', CoursePermission::EDIT_AS_MODERATOR)->delete();
        Permission::query()->where('name', '=', CoursePermission::DELETE_AS_ADMINISTRATOR)->delete();
        Permission::query()->where('name', '=', CoursePermission::DELETE_AS_MODERATOR)->delete();
        Permission::query()->where('name', '=', CoursePermission::SEE_AS_STUDENT)->delete();
        Permission::query()->where('name', '=', CoursePermission::PASS_AS_STUDENT)->delete();
    }
}

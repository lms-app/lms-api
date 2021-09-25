<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Modules\Test\ValueObjects\TestPermission;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Modules\Authorization\ValueObjects\Role as RoleVO;

final class CreateTestRoles extends Migration
{
    public function up():void
    {
        Permission::create(['name' => TestPermission::CREATE]);
        Permission::create(['name' => TestPermission::SEE_AS_ADMINISTRATOR]);
        Permission::create(['name' => TestPermission::SEE_AS_MODERATOR]);
        Permission::create(['name' => TestPermission::EDIT_AS_ADMINISTRATOR]);
        Permission::create(['name' => TestPermission::EDIT_AS_MODERATOR]);
        Permission::create(['name' => TestPermission::DELETE_AS_ADMINISTRATOR]);
        Permission::create(['name' => TestPermission::DELETE_AS_MODERATOR]);
        Permission::create(['name' => TestPermission::SEE_AS_STUDENT]);
        Permission::create(['name' => TestPermission::PASS_AS_STUDENT]);

        /** @var Role $administrator */
        $administrator = Role::query()->where('name', '=', RoleVO::ADMINISTRATOR)->first();
        $administrator->givePermissionTo(
            TestPermission::CREATE,
            TestPermission::SEE_AS_ADMINISTRATOR,
            TestPermission::EDIT_AS_ADMINISTRATOR,
            TestPermission::DELETE_AS_ADMINISTRATOR,
        );
        $administrator->save();

        /** @var Role $moderator */
        $moderator = Role::query()->where('name', '=', RoleVO::MODERATOR)->first();
        $moderator->givePermissionTo(
            TestPermission::CREATE,
            TestPermission::SEE_AS_MODERATOR,
            TestPermission::EDIT_AS_MODERATOR,
            TestPermission::DELETE_AS_MODERATOR,
        );
        $moderator->save();

        /** @var Role $student */
        $student = Role::query()->where('name', '=', RoleVO::STUDENT)->first();
        $student->givePermissionTo(
            TestPermission::SEE_AS_STUDENT,
            TestPermission::PASS_AS_STUDENT
        );
        $student->save();
    }

    public function down():void
    {
        Permission::query()->where('name', '=', TestPermission::CREATE)->delete();
        Permission::query()->where('name', '=', TestPermission::SEE_AS_ADMINISTRATOR)->delete();
        Permission::query()->where('name', '=', TestPermission::SEE_AS_MODERATOR)->delete();
        Permission::query()->where('name', '=', TestPermission::EDIT_AS_ADMINISTRATOR)->delete();
        Permission::query()->where('name', '=', TestPermission::EDIT_AS_MODERATOR)->delete();
        Permission::query()->where('name', '=', TestPermission::DELETE_AS_ADMINISTRATOR)->delete();
        Permission::query()->where('name', '=', TestPermission::DELETE_AS_MODERATOR)->delete();
        Permission::query()->where('name', '=', TestPermission::SEE_AS_STUDENT)->delete();
        Permission::query()->where('name', '=', TestPermission::PASS_AS_STUDENT)->delete();
    }
}

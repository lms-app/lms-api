<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Modules\Course\ValueObjects\CourseFolderPermission;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Modules\Authorization\ValueObjects\Role as RoleVO;

final class CreateFolderRoles extends Migration
{
    public function up():void
    {
        Permission::create(['name' => CourseFolderPermission::CREATE]);
        Permission::create(['name' => CourseFolderPermission::SEE_AS_ADMINISTRATOR]);
        Permission::create(['name' => CourseFolderPermission::SEE_AS_MODERATOR]);
        Permission::create(['name' => CourseFolderPermission::EDIT_AS_ADMINISTRATOR]);
        Permission::create(['name' => CourseFolderPermission::EDIT_AS_MODERATOR]);
        Permission::create(['name' => CourseFolderPermission::DELETE_AS_ADMINISTRATOR]);
        Permission::create(['name' => CourseFolderPermission::DELETE_AS_MODERATOR]);
        Permission::create(['name' => CourseFolderPermission::SEE_AS_STUDENT]);
        Permission::create(['name' => CourseFolderPermission::PASS_AS_STUDENT]);

        /** @var Role $administrator */
        $administrator = Role::query()->where('name', '=', RoleVO::ADMINISTRATOR)->first();
        $administrator->givePermissionTo(
            CourseFolderPermission::CREATE,
            CourseFolderPermission::SEE_AS_ADMINISTRATOR,
            CourseFolderPermission::EDIT_AS_ADMINISTRATOR,
            CourseFolderPermission::DELETE_AS_ADMINISTRATOR,
        );
        $administrator->save();

        /** @var Role $moderator */
        $moderator = Role::query()->where('name', '=', RoleVO::MODERATOR)->first();
        $moderator->givePermissionTo(
            CourseFolderPermission::CREATE,
            CourseFolderPermission::SEE_AS_MODERATOR,
            CourseFolderPermission::EDIT_AS_MODERATOR,
            CourseFolderPermission::DELETE_AS_MODERATOR,
        );
        $moderator->save();
    }

    public function down():void
    {
        Permission::query()->where('name', '=', CourseFolderPermission::CREATE)->delete();
        Permission::query()->where('name', '=', CourseFolderPermission::SEE_AS_ADMINISTRATOR)->delete();
        Permission::query()->where('name', '=', CourseFolderPermission::SEE_AS_MODERATOR)->delete();
        Permission::query()->where('name', '=', CourseFolderPermission::EDIT_AS_ADMINISTRATOR)->delete();
        Permission::query()->where('name', '=', CourseFolderPermission::EDIT_AS_MODERATOR)->delete();
        Permission::query()->where('name', '=', CourseFolderPermission::DELETE_AS_ADMINISTRATOR)->delete();
        Permission::query()->where('name', '=', CourseFolderPermission::DELETE_AS_MODERATOR)->delete();
        Permission::query()->where('name', '=', CourseFolderPermission::SEE_AS_STUDENT)->delete();
        Permission::query()->where('name', '=', CourseFolderPermission::PASS_AS_STUDENT)->delete();
    }
}

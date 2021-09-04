<?php
declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Authorization\ValueObjects\Role;
use Modules\User\Entities\User;

final class UserDatabaseSeeder extends Seeder
{
    public function run():void
    {
        /** @var User $user */
        $user = User::factory()->create(
            [
                'name' => 'Админов Админ Адвминович',
                'email' => 'admin@lms.com',
                'password' => Hash::make('1234'),
            ]
        );
        $user->assignRole(Role::STUDENT, Role::ADMINISTRATOR);

        // $this->call("OthersTableSeeder");
    }
}

<?php
declare(strict_types=1);

namespace Modules\Test\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

final class TestDatabaseSeeder extends Seeder
{
    public function run():void
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
    }
}

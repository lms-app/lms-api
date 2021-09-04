<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateGroupUserTable extends Migration
{
    public function up():void
    {
        Schema::create('group_users', function (Blueprint $table) {
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->primary([
                'group_id',
                'user_id',
            ]);
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('group_users');
    }
}

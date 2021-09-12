<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateGroupTable extends Migration
{
    public function up():void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('groups');
    }
}

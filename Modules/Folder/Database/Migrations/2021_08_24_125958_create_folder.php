<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateFolder extends Migration
{
    public function up():void
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('entity_type');
            $table->string('title')->nullable();
            $table->boolean('inherit_access')->default(false);
            $table->foreignId('parent_id')->nullable()->constrained('folders')->onDelete('cascade');
            $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('color')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('folders');
    }
}

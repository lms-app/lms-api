<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateEntityTable extends Migration
{
    public function up():void
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type');
            $table->string('title')->nullable();
            $table->string('status');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('folder_id')->nullable()->constrained('folders')->onDelete('cascade');
            $table->text('admin_notes')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('entities');
    }
}

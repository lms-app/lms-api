<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateVisibilityGroupsTable extends Migration
{
    public function up():void
    {
        Schema::create('visibility_groups', function (Blueprint $table) {
            $table->foreignId('entity_id')->nullable()->constrained('entities')->onDelete('cascade');
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->primary([
                'entity_id',
                'group_id',
            ]);
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('visibility_groups');
    }
}

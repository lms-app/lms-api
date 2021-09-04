<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateCourseTable extends Migration
{
    public function up():void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->foreignId('entity_id')->nullable()->constrained('entities')->onDelete('cascade');
            $table->integer('attempts_count')->default(1);
            $table->boolean('after_finished_view_element_access')->default(false);
            $table->boolean('section_sequential_passage')->default(false);
            $table->timestamps();
            $table->primary('entity_id');
        });
    }

    public function down():void
    {
        Schema::dropIfExists('courses');
    }
}

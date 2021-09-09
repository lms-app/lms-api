<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateCourseElementsTable extends Migration
{
    public function up():void
    {
        Schema::create('course_elements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->nullable()->constrained('course_sections')->onDelete('cascade');
            $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->integer('sort_order')->default(100);
            $table->string('type');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('body')->nullable();
            $table->foreignId('file_id')->nullable()->constrained('files')->onDelete('cascade');
            $table->integer('attempt_count');
            $table->float('pass_score');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('course_elements');
    }
}

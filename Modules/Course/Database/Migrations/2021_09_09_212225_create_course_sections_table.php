<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateCourseSectionsTable extends Migration
{
    public function up():void
    {
        Schema::create('course_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->nullable()->constrained('entities')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('course_sections')->onDelete('cascade');
            $table->integer('sort_order')->default(100);
            $table->float('pass_score')->default(0);
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->text('admin_notes')->nullable();
            $table->boolean('finish_course_on_fail')->default(false);
            $table->boolean('show_results')->default(false);
            $table->boolean('sequential_passage')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('course_sections');
    }
}

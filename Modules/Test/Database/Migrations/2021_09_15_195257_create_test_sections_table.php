<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateTestSectionTable extends Migration
{
    public function up():void
    {
        Schema::create('test_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained('entities')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('course_sections')->onDelete('cascade');
            $table->integer('sort_order')->default(100);
            $table->float('pass_score')->default(0);
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->text('admin_notes')->nullable();
            $table->boolean('shake_questions')->default(false);
            $table->boolean('shake_answers')->default(false);
            $table->boolean('random_selection')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('test_sections');
    }
}

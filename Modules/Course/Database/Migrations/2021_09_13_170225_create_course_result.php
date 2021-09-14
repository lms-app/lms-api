<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateCourseResult extends Migration
{
    public function up():void
    {
        Schema::create('course_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('entity_id')->constrained('entities')->onDelete('cascade');
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            $table->foreignId('section_id')->nullable()->constrained('course_sections')->onDelete('cascade');
            $table->foreignId('element_id')->nullable()->constrained('course_elements')->onDelete('cascade');
            $table->float('points');
            $table->boolean('is_finished')->default(false);
            $table->softDeletes();
            $table->unique(
                [
                    'user_id',
                    'entity_id',
                    'appointment_id',
                    'section_id',
                    'element_id',
                    'deleted_at',
                ],
                'unique_results'
            );
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('course_results');
    }
}

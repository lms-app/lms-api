<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateTestTable extends Migration
{
    public function up():void
    {
        Schema::create('test', function (Blueprint $table) {
            $table->foreignId('entity_id')->constrained('entities')->onDelete('cascade');
            $table->integer('attempts_count')->default(1);
            $table->boolean('strict_navigation')->default(false);
            $table->float('pass_score');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('entity_id');
        });
    }

    public function down():void
    {
        Schema::dropIfExists('test');
    }
}

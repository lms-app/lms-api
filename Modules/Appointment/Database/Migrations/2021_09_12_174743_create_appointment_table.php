<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateAppointmentTable extends Migration
{
    public function up():void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('entity_id')->constrained('entities')->onDelete('cascade');
            $table->dateTime('date_start');
            $table->dateTime('date_end')->nullable();
            $table->string('status');
            $table->integer('attempts_max');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(
                [
                    'user_id',
                    'entity_id',
                    'status',
                    'deleted_at',
                ]
            );
        });
    }

    public function down():void
    {
        Schema::dropIfExists('appointments');
    }
}

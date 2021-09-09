<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateFileTable extends Migration
{
    public function up():void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('original_name', 255);
            $table->string('file_name', 255);
            $table->string('public_path', 255);
            $table->string('file_path', 255);
            $table->string('mime_type', 255);
            $table->string('size', 255)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('files');
    }
}

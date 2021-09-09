<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\File\Http\Controllers\FileController;

Route::group([], static function() {
    Route::post('/', [FileController::class, 'create']);
});

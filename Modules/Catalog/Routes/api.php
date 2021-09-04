<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Catalog\Http\Controllers\CatalogController;

Route::group([], function() {
        Route::get('/counters/student', [CatalogController::class, 'countForStudent']);
        Route::get('/counters/moderator', [CatalogController::class, 'countForModerator']);
    }
);

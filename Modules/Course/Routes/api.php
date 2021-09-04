<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Course\Http\Controllers\CourseController;

Route::group([], static function() {
    Route::post('/', [CourseController::class, 'create']);
    Route::get('/{id}', [CourseController::class, 'getById']);
    Route::get('/{id}/preview', [CourseController::class, 'preview']);
    Route::put('/{id}', [CourseController::class, 'update']);
    Route::delete('/{id}', [CourseController::class, 'delete']);
    Route::get('/catalog/student', [CourseController::class, 'catalogStudent']);
    Route::get('/catalog/moderator', [CourseController::class, 'catalogModerator']);
    Route::get('/catalog/tags/student', [CourseController::class, 'getCatalogStudentTags']);
    Route::get('/catalog/tags/moderator', [CourseController::class, 'getCatalogModeratorTags']);
});


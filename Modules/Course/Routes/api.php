<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Course\Http\Controllers\CourseController;
use Modules\Course\Http\Controllers\CourseSectionController;
use Modules\Course\Http\Controllers\CourseSectionElementController;

Route::group([], static function() {
    Route::post('/', [CourseController::class, 'create']);
    Route::get('/{course_id}', [CourseController::class, 'getById']);
    Route::get('/{course_id}/preview', [CourseController::class, 'preview']);
    Route::put('/{course_id}', [CourseController::class, 'update']);
    Route::delete('/{course_id}', [CourseController::class, 'delete']);
    Route::get('/catalog/student', [CourseController::class, 'catalogStudent']);
    Route::get('/catalog/moderator', [CourseController::class, 'catalogModerator']);
    Route::get('/catalog/tags/student', [CourseController::class, 'getCatalogStudentTags']);
    Route::get('/catalog/tags/moderator', [CourseController::class, 'getCatalogModeratorTags']);
    Route::post('/{course_id}/appointment', [CourseController::class, 'createAppointment']);
    Route::get('/{course_id}/appointment', [CourseController::class, 'getAppointment']);
    Route::post('/{course_id}/section', [CourseSectionController::class, 'create']);
    Route::put('/section/{section_id}', [CourseSectionController::class, 'update']);
    Route::delete('/section/{section_id}', [CourseSectionController::class, 'delete']);
    Route::get('/section/{section_id}', [CourseSectionController::class, 'get']);
    Route::post('/section/{section_id}/element', [CourseSectionElementController::class, 'create']);
    Route::put('/section/element/{element_id}', [CourseSectionElementController::class, 'update']);
    Route::get('/section/element/{element_id}', [CourseSectionElementController::class, 'get']);
    Route::delete('/section/element/{element_id}', [CourseSectionElementController::class, 'delete']);
});


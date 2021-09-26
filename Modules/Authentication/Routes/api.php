<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Authentication\Http\Controllers\AuthenticationControllerInterface;

Route::group([], static function() {
    Route::post('/login', [AuthenticationControllerInterface::class, 'login']);
    Route::post('/password', [AuthenticationControllerInterface::class, 'password']);
    Route::post('/signup', [AuthenticationControllerInterface::class, 'signup']);
    Route::post('/token/refresh', [AuthenticationControllerInterface::class, 'tokenRefresh']);
});


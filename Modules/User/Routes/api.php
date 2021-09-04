<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserProfileInterface;

Route::group([], static function() {
    Route::get('/profile', [UserProfileInterface::class, 'profile']);
});

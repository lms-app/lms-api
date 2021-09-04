<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\User\Http\Requests\ProfileRequest;

interface UserProfileInterface
{
    public function profile(ProfileRequest $profileRequest): JsonResponse;
}

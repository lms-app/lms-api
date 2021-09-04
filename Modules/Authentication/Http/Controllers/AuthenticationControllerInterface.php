<?php
declare(strict_types=1);

namespace Modules\Authentication\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Authentication\Http\Requests\LoginRequest;
use Modules\Authentication\Http\Requests\PasswordRequest;
use Modules\Authentication\Http\Requests\TokenRefreshRequest;

interface AuthenticationControllerInterface
{
    public function login(LoginRequest $loginRequest): JsonResponse;
    public function password(PasswordRequest $passwordRequest):JsonResponse;
    public function tokenRefresh(TokenRefreshRequest $tokenRefreshRequest):JsonResponse;
}

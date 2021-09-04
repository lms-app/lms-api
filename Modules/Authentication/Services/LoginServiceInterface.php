<?php
declare(strict_types=1);

namespace Modules\Authentication\Services;

use Illuminate\Http\JsonResponse;
use Modules\User\ValueObjects\LoginValueInterface;

interface LoginServiceInterface
{
    public function login(LoginValueInterface $login):JsonResponse;
}

<?php
declare(strict_types=1);

namespace Modules\Authentication\Services;

use Illuminate\Http\JsonResponse;
use Modules\Authentication\ValueObjects\Device;
use Modules\Authentication\ValueObjects\Login;
use Modules\Authentication\ValueObjects\LoginKey;
use Modules\Authentication\ValueObjects\Password;
use Modules\User\ValueObjects\LoginValueInterface;

interface SignupServiceInterface
{
    public function signup(LoginValueInterface $login, Password $password, Device $device):JsonResponse;
}

<?php
declare(strict_types=1);

namespace Modules\Authentication\Services;

use Illuminate\Http\JsonResponse;
use Modules\Authentication\ValueObjects\Device;
use Modules\Authentication\ValueObjects\LoginKey;
use Modules\Authentication\ValueObjects\Password;

interface PasswordServiceInterface
{
    public function password(LoginKey $key, Password $password, Device $device):JsonResponse;
}

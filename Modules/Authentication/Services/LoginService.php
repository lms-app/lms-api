<?php
declare(strict_types=1);


namespace Modules\Authentication\Services;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Modules\Authentication\ValueObjects\LoginKey;
use Modules\User\ValueObjects\LoginValueInterface;

final class LoginService implements LoginServiceInterface
{
    public function login(LoginValueInterface $login): JsonResponse
    {
        $key = LoginKey::create(
            sha1(microtime(true) . date('Y:m:d H:i:s'))
        );

        Cache::put($key->__toString(),
            [
                'login' => $login->get(),
                'type' => $login->type(),
            ]
        );

        return new JsonResponse(
            [
                'data' => [
                    'status' => 'ok',
                    'key' => $key,
                    'step' => 'password',
                ]
            ]
        );
    }
}

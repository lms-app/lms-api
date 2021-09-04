<?php
declare(strict_types=1);


namespace Modules\Authentication\Services;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Modules\Authentication\ValueObjects\Device;
use Modules\Authentication\ValueObjects\LoginKey;
use Modules\Authentication\ValueObjects\Password;
use Modules\User\Entities\User;
use Modules\User\ValueObjects\Email;
use Modules\User\ValueObjects\LoginValueFactory;
use Symfony\Component\HttpFoundation\Response;

final class PasswordService implements PasswordServiceInterface
{
    public function password(LoginKey $key, Password $password, Device $device): JsonResponse
    {
        $cachedData = Cache::get($key->__toString());

        if (!isset($cachedData['login']) && !isset($cachedData['type'])) {
            return new JsonResponse(
                [
                    'data' =>
                        [
                            'status' => 'error',
                            'massages' => 'Key no exist',
                            'code' => 4008,
                            'status_code' => 400,
                        ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $loginValue = LoginValueFactory::createByType(
            $cachedData['type'],
            $cachedData['login'],
        );

        $userQuery = User::query();

        if ($loginValue instanceof Email) {
            $userQuery = $userQuery
                ->where(
                    'email',
                    '=',
                    $loginValue
                );
        }

        try {
            /** @var User $user */
            $user = $userQuery->first();

            if ($user === null) {
                throw new \RuntimeException('User not exist');
            }

            if (!Hash::check($password->__toString(), $user->getAuthPassword())) {
                throw new \RuntimeException('Password not exist');
            }

            $user->tokens()
                ->where('tokenable_id', '=', $user->getId())
                ->where('name', '=', $device->__toString())
                ->delete();

            $token = $user
                ->createToken(
                    $device->__toString()
                )
                ->plainTextToken;

            return new JsonResponse(
                [
                    'data' => [
                        'status' => 'ok',
                        'object' => 'Authentication',
                        'accessToken' => $token,
                        'tokenInfo' => [
                            'id' => $user->getId(),
                            'fullname' => $user->getFullName(),
                            'exp' => (new \DateTimeImmutable('+3 hours'))->format('Y-m-d H:i:s'),
                        ],
                        'tokenExpires' => [],
                        'tokenType' => 'Bearer',
                        'confirm_tabnr' => true,
                    ]
                ]
            );
        } catch (\Throwable $exception) {
            return new JsonResponse(
                [
                    'data' =>
                        [
                            'status' => 'error',
                            'massages' => 'Wrong password',
                            'code' => 4002,
                            'status_code' => 400,
                        ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}

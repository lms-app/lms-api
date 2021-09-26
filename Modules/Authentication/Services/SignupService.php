<?php
declare(strict_types=1);


namespace Modules\Authentication\Services;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Modules\Authentication\ValueObjects\Device;
use Modules\Authentication\ValueObjects\Login;
use Modules\Authentication\ValueObjects\LoginKey;
use Modules\Authentication\ValueObjects\Password;
use Modules\User\Entities\User;
use Modules\User\Exceptions\UserNotFoundException;
use Modules\User\ValueObjects\Email;
use Modules\User\ValueObjects\LoginValueFactory;
use Modules\User\ValueObjects\LoginValueInterface;
use Symfony\Component\HttpFoundation\Response;

final class SignupService implements SignupServiceInterface
{
    public function signup(LoginValueInterface $login, Password $password, Device $device): JsonResponse
    {
        try {
            $user = User::findByLogin($login);
        } catch (UserNotFoundException $exception){
            $user = null;
        }

        try {
            if ($user !== null) {
                throw new \RuntimeException('User already exist');
            }

            $user = User::query()->create(
                [
                    'email' => $login->get(),
                    'password' => Hash::make($password->__toString()),
                ]
            );

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
            var_dump($exception->getMessage(), $exception->getFile(), $exception->getLine());
            return new JsonResponse(
                [
                    'data' =>
                        [
                            'status' => 'error',
                            'massages' => 'Wrong wrong',
                            'code' => 4002,
                            'status_code' => 400,
                        ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}

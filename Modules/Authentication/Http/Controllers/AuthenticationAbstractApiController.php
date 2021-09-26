<?php
declare(strict_types=1);

namespace Modules\Authentication\Http\Controllers;

use App\Http\Controllers\AbstractApiController;
use Illuminate\Http\JsonResponse;
use Modules\Authentication\Http\Requests\LoginRequest;
use Modules\Authentication\Http\Requests\PasswordRequest;
use Modules\Authentication\Http\Requests\SignupRequest;
use Modules\Authentication\Http\Requests\TokenRefreshRequest;
use Modules\Authentication\Services\LoginServiceInterface;
use Modules\Authentication\Services\PasswordServiceInterface;
use Modules\Authentication\Services\SignupServiceInterface;
use Modules\User\Entities\User;


final class AuthenticationAbstractApiController extends AbstractApiController implements AuthenticationControllerInterface
{
    private LoginServiceInterface $loginService;
    private PasswordServiceInterface $passwordService;
    private SignupServiceInterface $signupService;

    public function __construct(
        LoginServiceInterface    $loginService,
        PasswordServiceInterface $passwordService,
        SignupServiceInterface   $signupService,
    )
    {
        $this->loginService = $loginService;
        $this->passwordService = $passwordService;
        $this->signupService = $signupService;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/authentication/login",
     *      tags={"Authentication"},
     *      summary="Логин по email или телефону",
     *      description="Логин по email или телефону",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="login", type="string", description="Логин для входа", example="user@lms.com")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", description="Статус", example="ok"),
     *              @OA\Property(property="step", type="string", description="Следующий шаг", example="password"),
     *              @OA\Property(property="key", type="string", description="Ключ для пароля", example="2085b0d72401d12d7cdb77a1ad3381d00d96f1f9")
     *          ),
     *       )
     *     )
     */
    public function login(LoginRequest $loginRequest):JsonResponse
    {
        return $this->loginService->login(
            $loginRequest->getLogin()
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/authentication/password",
     *      tags={"Authentication"},
     *      summary="Вход по ключу и паролю",
     *      description="Вход по ключу и паролю",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="key", type="string", description="Ключ от шага логин", example="2085b0d72401d12d7cdb77a1ad3381d00d96f1f9"),
     *              @OA\Property(property="password", type="string", description="Пароль для входа", example="qwery")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", description="Статус", example="ok"),
     *              @OA\Property(property="object", type="string", description="Объект", example="Authentication"),
     *              @OA\Property(property="accessToken", type="string", description="Токен для входа", example="")
     *          ),
     *       )
     *     )
     */
    public function password(PasswordRequest $passwordRequest):JsonResponse
    {
        return $this->passwordService->password(
            $passwordRequest->getKey(),
            $passwordRequest->getPasswordVO(),
            $passwordRequest->getDeviceVO()
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/authentication/signup",
     *      tags={"Authentication"},
     *      summary="Регистрация нового пользователя",
     *      description="Регистрация нового пользователя",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="login", type="string", description="почта", example="test@test.com"),
     *              @OA\Property(property="password", type="string", description="Пароль для входа", example="qwery")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", description="Статус", example="ok"),
     *              @OA\Property(property="object", type="string", description="Объект", example="Authentication"),
     *              @OA\Property(property="accessToken", type="string", description="Токен для входа", example="")
     *          ),
     *       )
     *     )
     */
    public function signup(SignupRequest $signupRequest):JsonResponse
    {
        return $this->signupService->signup(
            $signupRequest->getLogin(),
            $signupRequest->getPassword(),
            $signupRequest->getDeviceVO()
        );
    }

    public function tokenRefresh(TokenRefreshRequest $tokenRefreshRequest):JsonResponse
    {
        /** @var User $user */
        $user = $tokenRefreshRequest->user();

        return new JsonResponse(
            [
                'data' => [
                    'status' => 'ok',
                    'object' => 'Authentication',
                    'accessToken' => $user->tokens()
                        ->where('tokenable_id', '=', $user->getId())
                        ->first()->plainTextToken,
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
    }
}

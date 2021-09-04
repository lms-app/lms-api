<?php
declare(strict_types=1);

namespace Modules\Authentication\Http\Requests;

use App\Requests\FormRequest;
use Modules\User\ValueObjects\Email;
use Modules\User\ValueObjects\LoginValueInterface;

/**
 * @property string $login
 */
final class LoginRequest extends FormRequest
{
    public function authorize():bool
    {
        return true;
    }

    public function rules():array
    {
        return [
            'login,required'
        ];
    }

    public function getLogin():LoginValueInterface
    {
        if (str_contains($this->login, '@')) {
            return Email::create($this->login);
        }
        throw new \LogicException('Login is not supporting');
    }
}

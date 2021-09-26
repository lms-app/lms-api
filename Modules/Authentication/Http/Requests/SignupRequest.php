<?php
declare(strict_types=1);

namespace Modules\Authentication\Http\Requests;

use App\Requests\FormRequest;
use Modules\Authentication\ValueObjects\Device;
use Modules\Authentication\ValueObjects\LoginKey;
use Modules\Authentication\ValueObjects\Password;
use Modules\User\ValueObjects\LoginValueFactory;
use Modules\User\ValueObjects\LoginValueInterface;

/**
 * @property string $login
 * @property string $password
 * @property string $type
 */
final class SignupRequest extends FormRequest
{
    public function authorize():bool
    {
        return true;
    }

    public function rules():array
    {
        return [
            'login,required',
            'password,required',
        ];
    }

    public function getLogin():LoginValueInterface
    {
        return LoginValueFactory::createByType(LoginValueFactory::TYPE_EMAIL, $this->login);
    }

    public function getPassword():Password
    {
        return Password::create($this->password);
    }

    public function getDeviceVO():Device
    {
        return Device::create(
            $this->header('Device-Udid')
        );
    }
}

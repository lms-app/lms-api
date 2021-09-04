<?php
declare(strict_types=1);

namespace Modules\Authentication\Http\Requests;

use App\Requests\FormRequest;
use Modules\Authentication\ValueObjects\Device;
use Modules\Authentication\ValueObjects\LoginKey;
use Modules\Authentication\ValueObjects\Password;

/**
 * @property string $key
 * @property string $password
 */
final class PasswordRequest extends FormRequest
{
    public function authorize():bool
    {
        return true;
    }

    public function rules():array
    {
        return [
            'key,required',
            'password,required',
        ];
    }

    public function getKey():LoginKey
    {
        return LoginKey::create($this->key);
    }

    public function getPasswordVO():Password
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

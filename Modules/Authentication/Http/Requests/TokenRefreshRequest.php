<?php
declare(strict_types=1);

namespace Modules\Authentication\Http\Requests;


use App\Requests\FormRequest;

/**
 * @property string $token
 */
final class TokenRefreshRequest extends FormRequest
{
    public function authorize():bool
    {
        return true;
    }
}

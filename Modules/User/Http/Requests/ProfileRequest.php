<?php
declare(strict_types=1);

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ProfileRequest extends FormRequest
{
    public function rules():array
    {
        return [];
    }
}

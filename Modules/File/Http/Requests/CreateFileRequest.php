<?php
declare(strict_types=1);

namespace Modules\File\Http\Requests;

use App\Requests\FormRequest;

final class CreateFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file.*' => 'required|file',
        ];
    }

    public function authorize():bool
    {
        return true;
    }
}

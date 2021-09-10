<?php
declare(strict_types=1);


namespace App\Responses;


use Illuminate\Http\JsonResponse;

final class DeleteResourceResponse extends JsonResponse
{
    public static function get():JsonResponse
    {
        return new JsonResponse(
            [
                'deleted' => 'ok',
            ]
        );
    }
}

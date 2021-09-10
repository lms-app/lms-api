<?php
declare(strict_types=1);


namespace App\Responses;


use App\ValueObjects\LimitValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

final class DataResponse extends JsonResponse
{
    public static function getResponse(Model $model):JsonResponse
    {
        return new JsonResponse(
            [
                'data' => $model,
            ]
        );
    }
}

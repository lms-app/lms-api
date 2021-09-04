<?php
declare(strict_types=1);


namespace App\Responses;


use App\ValueObjects\LimitValue;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

final class PaginatorResponse extends JsonResponse
{
    public static function getResponse(LengthAwarePaginator $paginator):JsonResponse
    {
        $result = [];

        $paginationCollection = $paginator->getCollection()
            ->forPage(
                $paginator->currentPage(),
                $paginator->perPage()
            );

        foreach ($paginationCollection as $item) {
            $result[] = $item;
        }

        return new JsonResponse(
            [
                'data' => $result,
                'meta' => [
//                    'include'    => [],
//                    'custom'     => [],
                    'pagination' => [
                        'total'        => $paginator->total(),
                        'count'        => $paginator->count(),
                        'per_page'     => LimitValue::LIMIT_DEFAULT,
                        'current_page' => $paginator->currentPage(),
                        'total_pages'  => $paginator->lastPage(),
                    ]
                ]
            ]
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\ValueObjects\OrderByValue;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="LMS ",
 *      description="LMS ",
 *      @OA\Contact(
 *          email="admin@admin.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 */
/**
 *  @OA\Get(
 *     path="/",
 *     description="Home page",
 *     @OA\Response(response="default", description="Welcome page")
 * )
 */
abstract class AbstractApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sortBy(Collection $collection, ?OrderByValue $orderByValue):Collection
    {
        if ($orderByValue === null) {
            return $collection;
        }

        return $collection->sortBy(
            $orderByValue->field(),
            SORT_REGULAR,
            $orderByValue->direction()
        );
    }
}

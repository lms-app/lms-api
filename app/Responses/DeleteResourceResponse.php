<?php
declare(strict_types=1);


namespace App\Responses;


use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 *   schema="Resource.DeleteResponse",
 *   type="object",
 *   @OA\Property(property="deleted", type="string", example="ok"),
 * )
 */
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

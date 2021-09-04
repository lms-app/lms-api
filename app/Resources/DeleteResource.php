<?php
declare(strict_types=1);


namespace App\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

final class DeleteResource extends JsonResource
{
    public const DELETE_RESPONSE = [
        'deleted' => 'ok'
    ];
}

<?php
declare(strict_types=1);

namespace Modules\Appointment\Http\Responses;


use Illuminate\Http\JsonResponse;
use Modules\Appointment\Entities\Appointment;

/**
 * @OA\Schema(
 *   schema="Appointment.AppointmentDataResponse",
 *   type="object",
 *   @OA\Property(property="id", type="integer", description="ID назначения", example=""),
 *   @OA\Property(property="user_id", type="integer", description="ID пользователя", example="10"),
 *   @OA\Property(property="entity_id", type="integer", description="ID сущности", example="10"),
 *   @OA\Property(property="attempts_max", type="integer", description="максимальное количество попыток на прохождение", example="10"),
 *   @OA\Property(property="date_start", type="string", description="дата начала назнчения", example="2025-01-02 11:33:44"),
 *   @OA\Property(property="date_end", type="string", description="дата окончания назнчения", example="2030-01-02 11:33:44"),
 * )
 */
final class AppointmentDataResponse extends JsonResponse
{
    public static function get(Appointment $appointment):self
    {
        return new self(
            [
                'data' => [
                    'id' => $appointment->getId(),
                    'status' => $appointment->getStatus(),
                    'user_id' => $appointment->getUserId(),
                    'entity_id' => $appointment->getEntityId(),
                    'date_start' => $appointment->getDateStart(),
                    'date_end' => $appointment->getDateEnd(),
                    'attempts_max' => $appointment->getAttemptsMax(),
                ]
            ]
        );
    }
}

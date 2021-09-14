<?php
declare(strict_types=1);

namespace Modules\Course\Http\Controllers;

use App\Http\Controllers\AbstractApiController;
use Modules\Course\Http\Requests\Result\CourseResultRequest;
use Modules\Course\Http\Responses\CourseDataResponse;
use Modules\Course\Http\Responses\Result\CourseResultDataResponse;
use Modules\Course\Services\CourseResultServiceInterface;
use Modules\Entity\ValueObjects\EntityType;

final class CourseResultController extends AbstractApiController
{
    private CourseResultServiceInterface $courseResultService;

    public function __construct(
        CourseResultServiceInterface $courseResultService
    )
    {
        $this->courseResultService = $courseResultService;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/course/appointment/{appointment_id}/result",
     *      tags={"Course"},
     *      summary="Создание курса",
     *      description="Создание курса",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *          ),
     *       )
     *     )
     */
    public function create(CourseResultRequest $courseResultRequest): CourseResultDataResponse
    {
        return CourseResultDataResponse::get(
            $this->courseResultService->finish(
                $courseResultRequest
            )
        );
    }
}

<?php
declare(strict_types=1);

namespace Modules\Course\Http\Controllers;

use App\Http\Controllers\AbstractApiController;
use Illuminate\Http\JsonResponse;
use Modules\Course\Http\Requests\Element\CreateCourseElementRequest;
use Modules\Course\Http\Responses\Element\CourseElementDataResponse;
use Modules\Course\Services\CourseElementServiceInterface;

final class CourseSectionElementController extends AbstractApiController
{
    private CourseElementServiceInterface $elementService;

    public function __construct(CourseElementServiceInterface $elementService)
    {
        $this->elementService = $elementService;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/course/section/{section_id}/element",
     *      tags={"Course", "Course Element"},
     *      summary="Создание элемента в секции курса",
     *      description="Создание элемента в секции курса",
     *      @OA\Parameter(
     *          parameter="section_id",
     *          name="section_id",
     *          required=true,
     *          description="Id секции",
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *          ),
     *          in="path",
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="file_id", type="integer", description="ID файла", example="секция 1"),
     *              @OA\Property(property="title", type="string", description="Название элемента", example="секция 1"),
     *              @OA\Property(property="description", type="string", description="описание элемента", example=""),
     *              @OA\Property(property="author_id", type="integer", description="ID пользователя", example="10"),
     *              @OA\Property(property="sort_order", type="integer", description="Порядок сортировки", example="100"),
     *              @OA\Property(property="type", type="string", description="тип элемента", example="text"),
     *              @OA\Property(property="body", type="string", description="тело элемента", example="Тело элемента"),
     *              @OA\Property(property="attempt_count", type="integer", description="количество попыток прохождения элемента", example="3"),
     *              @OA\Property(property="pass_score", type="integer", description="количество баллов за прохождение элемента", example="10"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="file_id", type="integer", description="ID файла", example="секция 1"),
     *              @OA\Property(property="title", type="string", description="Название элемента", example="секция 1"),
     *              @OA\Property(property="description", type="string", description="описание элемента", example=""),
     *              @OA\Property(property="author_id", type="integer", description="ID пользователя", example="10"),
     *              @OA\Property(property="sort_order", type="integer", description="Порядок сортировки", example="100"),
     *              @OA\Property(property="type", type="string", description="тип элемента", example="text"),
     *              @OA\Property(property="body", type="string", description="тело элемента", example="Тело элемента"),
     *              @OA\Property(property="attempt_count", type="integer", description="количество попыток прохождения элемента", example="3"),
     *              @OA\Property(property="pass_score", type="integer", description="количество баллов за прохождение элемента", example="10"),
     *          ),
     *       )
     *     )
     */
    public function create(CreateCourseElementRequest $createCourseElementRequest): JsonResponse
    {
        return CourseElementDataResponse::get(
            $this->elementService->createElement(
                $createCourseElementRequest
                    ->merge(
                        [
                            'author_id' => $createCourseElementRequest->user()->getId(),
                            'section_id' => $createCourseElementRequest->getSectionId(),
                        ]
                    )
                    ->all()
            )
        );
    }
}
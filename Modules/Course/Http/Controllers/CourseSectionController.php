<?php
declare(strict_types=1);

namespace Modules\Course\Http\Controllers;

use App\Http\Controllers\AbstractApiController;
use App\Responses\DeleteResourceResponse;
use Illuminate\Http\JsonResponse;
use Modules\Course\Http\Requests\Section\CreateCourseSectionRequest;
use Modules\Course\Http\Requests\Section\DeleteCourseSectionByIdRequest;
use Modules\Course\Http\Requests\Section\GetCourseSectionByIdRequest;
use Modules\Course\Http\Requests\Section\UpdateCourseSectionByIdRequest;
use Modules\Course\Http\Responses\CourseSectionDataResponse;
use Modules\Course\Services\CourseSectionServiceInterface;
use Symfony\Component\HttpFoundation\Response;

final class CourseSectionController extends AbstractApiController
{
    private CourseSectionServiceInterface $courseSectionService;

    public function __construct(CourseSectionServiceInterface $courseSectionService)
    {
        $this->courseSectionService = $courseSectionService;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/course/{course_id}/section",
     *      tags={"Course", "Course Section"},
     *      summary="Создание секции курса",
     *      description="Создание секции курса",
     *      @OA\Parameter(
     *          parameter="course_id",
     *          name="course_id",
     *          required=true,
     *          description="Id курса",
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *          ),
     *          in="path",
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="title", type="string", description="Название секции", example="секция 1"),
     *              @OA\Property(property="description", type="string", description="описание секции", example=""),
     *              @OA\Property(property="admin_notes", type="string", description="заметки модератора", example=""),
     *              @OA\Property(property="author_id", type="integer", description="ID пользователя", example="10"),
     *              @OA\Property(property="entity_id", type="integer", description="ID сущности", example="100"),
     *              @OA\Property(property="parent_id", type="integer", description="ID родительской секции", example="100"),
     *              @OA\Property(property="sort_order", type="integer", description="Порядок сортировки", example="100"),
     *              @OA\Property(property="pass_score", type="integer", description="Баллы необходимые для прохождения секции", example="100"),
     *              @OA\Property(property="finish_course_on_fail", type="boolean", description="завершить курс при ошибки прохождения", example="false"),
     *              @OA\Property(property="show_results", type="boolean", description="показывать результаты прохождения", example="false"),
     *              @OA\Property(property="sequential_passage", type="boolean", description="последовательное прохождение", example="false"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Course.SectionDataResponse")
     *       )
     *     )
     */
    public function create(CreateCourseSectionRequest $createCourseSectionRequest): JsonResponse
    {
        return CourseSectionDataResponse::get(
            $this->courseSectionService->createSection(
                $createCourseSectionRequest
                    ->merge(
                        [
                            'author_id' => $createCourseSectionRequest->user()->getId(),
                            'entity_id' => $createCourseSectionRequest->getCourseId(),
                        ]
                    )
                    ->all()
            )
        );
    }

    /**
     * @OA\Put(
     *      path="/api/v1/course/section/{section_id}",
     *      tags={"Course", "Course Section"},
     *      summary="Обновление секции курса",
     *      description="Обновление секции курса",
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
     *              @OA\Property(property="title", type="string", description="Название секции", example="секция 1"),
     *              @OA\Property(property="description", type="string", description="описание секции", example=""),
     *              @OA\Property(property="admin_notes", type="string", description="заметки модератора", example=""),
     *              @OA\Property(property="author_id", type="integer", description="ID пользователя", example="10"),
     *              @OA\Property(property="entity_id", type="integer", description="ID сущности", example="100"),
     *              @OA\Property(property="parent_id", type="integer", description="ID родительской секции", example="100"),
     *              @OA\Property(property="sort_order", type="integer", description="Порядок сортировки", example="100"),
     *              @OA\Property(property="pass_score", type="integer", description="Баллы необходимые для прохождения секции", example="100"),
     *              @OA\Property(property="finish_course_on_fail", type="boolean", description="завершить курс при ошибки прохождения", example="false"),
     *              @OA\Property(property="show_results", type="boolean", description="показывать результаты прохождения", example="false"),
     *              @OA\Property(property="sequential_passage", type="boolean", description="последовательное прохождение", example="false"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Course.SectionDataResponse")
     *       )
     *     )
     */
    public function update(UpdateCourseSectionByIdRequest $updateCourseSectionByIdRequest): JsonResponse
    {
        return CourseSectionDataResponse::get(
            $this->courseSectionService->updateSection(
                $this->courseSectionService->getSectionById(
                    $updateCourseSectionByIdRequest->getSectionId()
                ),
                $updateCourseSectionByIdRequest
                    ->merge(
                        [
                            'author_id' => $updateCourseSectionByIdRequest->user()->getId(),
                        ]
                    )
                    ->all()
            )
        );
    }

    /**
     * @OA\Get (
     *      path="/api/v1/course/section/{section_id}",
     *      tags={"Course", "Course Section"},
     *      summary="Получение секции курса",
     *      description="Получение секции курса",
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
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Course.SectionDataResponse")
     *       )
     *     )
     */
    public function get(GetCourseSectionByIdRequest $getCourseSectionByIdRequest): JsonResponse
    {
        return CourseSectionDataResponse::get(
            $this->courseSectionService->getSectionById(
                $getCourseSectionByIdRequest->getSectionId()
            )
        );
    }

    /**
     * @OA\Delete (
     *      path="/api/v1/course/{id}/section/{section_id}",
     *      tags={"Course", "Course Section"},
     *      summary="Удаление секции курса",
     *      description="Удаление секции курса",
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
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="deleted", type="string", example="ok"),
     *          ),
     *       )
     *     )
     */
    public function delete(DeleteCourseSectionByIdRequest $deleteCourseSectionByIdRequest): JsonResponse
    {
        $this->courseSectionService->deleteSections(
            $deleteCourseSectionByIdRequest->getSectionId()
        );
        return DeleteResourceResponse::get();
    }
}

<?php
declare(strict_types=1);

namespace Modules\Course\Http\Controllers;

use App\Http\Controllers\AbstractApiController;
use App\Resources\DeleteResource;
use App\Responses\PaginatorResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Course\Http\Requests\CreateCourseRequest;
use Modules\Course\Http\Requests\DeleteCourseByIdRequest;
use Modules\Course\Http\Requests\GetCourseByIdRequest;
use Modules\Course\Http\Requests\GetCourseCatalogRequest;
use Modules\Course\Http\Requests\GetModeratorCourseCatalogRequest;
use Modules\Course\Http\Requests\GetPreviewCourseByIdRequest;
use Modules\Course\Http\Requests\UpdateCourseByIdRequest;
use Modules\Course\Http\Responses\CourseDataResponse;
use Modules\Course\Http\Responses\CoursePreviewResponse;
use Modules\Course\Resources\GetCoursePreviewResource;
use Modules\Course\Resources\GetCourseResource;
use Modules\Course\Services\CourseCatalogInterface;
use Modules\Course\Services\CourseServiceInterface;
use Modules\Entity\ValueObjects\EntityType;
use Symfony\Component\HttpFoundation\Response;

final class CourseController extends AbstractApiController
{
    private CourseServiceInterface $courseService;
    private CourseCatalogInterface $courseCatalogService;

    public function __construct(
        CourseServiceInterface $courseService,
        CourseCatalogInterface $courseCatalogService
    )
    {
        $this->courseService = $courseService;
        $this->courseCatalogService = $courseCatalogService;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/course",
     *      tags={"Course"},
     *      summary="Создание курса",
     *      description="Создание курса",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="title", type="string", description="Название курса", example="Курс по космонавтике"),
     *              @OA\Property(property="status", type="string", description="Статус курса (открытый, закрытый, ограниченный)", example="open"),
     *              @OA\Property(property="short_description", type="string", description="Краткое описание курса", example=""),
     *              @OA\Property(property="description", type="string", description="Полное описание курса", example=""),
     *              @OA\Property(property="author_id", type="integer", description="ID пользователя", example="10"),
     *              @OA\Property(property="folder_id", type="integer", description="ID папки, по умолчанию null", example="100"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="title", type="string", description="Название курса", example="Курс по космонавтике"),
     *              @OA\Property(property="status", type="string", description="Статус курса (открытый, закрытый, ограниченный)", example="open"),
     *              @OA\Property(property="short_description", type="string", description="Краткое описание курса", example=""),
     *              @OA\Property(property="description", type="string", description="Полное описание курса", example=""),
     *              @OA\Property(property="author_id", type="integer", description="ID пользователя", example="10"),
     *              @OA\Property(property="folder_id", type="integer", description="ID папки, по умолчанию null", example="100"),
     *          ),
     *       )
     *     )
     */
    public function create(CreateCourseRequest $createCourseRequest): JsonResponse
    {
        $course = $this->courseService->createCourse(
            $createCourseRequest
                ->merge(
                    [
                        'author_id' => $createCourseRequest->user()->getId(),
                        'entity_type' => EntityType::create(EntityType::TYPE_COURSE)
                    ]
                )
                ->all()
        );
        $entity = $course->getEntity();

        return new JsonResponse(
            [
                'data' => [
                    'entity_id' => $entity->getId(),
                    'entity_type' => $entity->getEntityType(),
                    'author_id' => $entity->getAuthorId(),
                    'status' => $entity->getEntityStatus(),
                    'short_description' => $entity->getAttribute('short_description'),
                    'description' => $entity->getAttribute('description'),
                    'folder_id' => $entity->getAttribute('folder_id'),
                    'attempts_count' => $course->getAttribute('attempts_count'),
                    'after_finished_view_element_access' => $course->getAttribute('after_finished_view_element_access'),
                    'section_sequential_passage' => $course->getAttribute('section_sequential_passage'),
                ]
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/course/{id}",
     *      @OA\Parameter(
     *          parameter="id",
     *          name="id",
     *          required=true,
     *          description="Id курса",
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *          ),
     *          in="path",
     *      ),
     *      tags={"Course"},
     *      summary="Получение информации о курсе для модератора",
     *      description="Получение информации о курсе для модератора",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="title", type="string", description="Название курса", example="Курс по космонавтике"),
     *              @OA\Property(property="status", type="string", description="Статус курса (открытый, закрытый, ограниченный)", example="open"),
     *              @OA\Property(property="short_description", type="string", description="Краткое описание курса", example=""),
     *              @OA\Property(property="description", type="string", description="Полное описание курса", example=""),
     *              @OA\Property(property="author_id", type="integer", description="ID пользователя", example="10"),
     *              @OA\Property(property="folder_id", type="integer", description="ID папки, по умолчанию null", example="100"),
     *          ),
     *       )
     *     )
     */
    public function getById(GetCourseByIdRequest $courseByIdRequest): CourseDataResponse
    {
        return CourseDataResponse::get(
            $this->courseService->getCourseById(
                $courseByIdRequest->getId()
            )
        );
    }

    /**
     * @OA\Put(
     *      path="/api/v1/course/{id}",
     *      @OA\Parameter(
     *          parameter="id",
     *          name="id",
     *          required=true,
     *          description="Id курса",
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *          ),
     *          in="path",
     *      ),
     *      tags={"Course"},
     *      summary="Обновление информации о курсе для модератора",
     *      description="Обновление информации о курсе для модератора",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="title", type="string", description="Название курса", example="Курс по космонавтике"),
     *              @OA\Property(property="status", type="string", description="Статус курса (открытый, закрытый, ограниченный)", example="open"),
     *              @OA\Property(property="short_description", type="string", description="Краткое описание курса", example=""),
     *              @OA\Property(property="description", type="string", description="Полное описание курса", example=""),
     *              @OA\Property(property="author_id", type="integer", description="ID пользователя", example="10"),
     *              @OA\Property(property="folder_id", type="integer", description="ID папки, по умолчанию null", example="100"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="title", type="string", description="Название курса", example="Курс по космонавтике"),
     *              @OA\Property(property="status", type="string", description="Статус курса (открытый, закрытый, ограниченный)", example="open"),
     *              @OA\Property(property="short_description", type="string", description="Краткое описание курса", example=""),
     *              @OA\Property(property="description", type="string", description="Полное описание курса", example=""),
     *              @OA\Property(property="author_id", type="integer", description="ID пользователя", example="10"),
     *              @OA\Property(property="folder_id", type="integer", description="ID папки, по умолчанию null", example="100"),
     *          ),
     *       )
     *     )
     */
    public function update(UpdateCourseByIdRequest $updateCourseByIdRequest): CourseDataResponse
    {
        return CourseDataResponse::get(
            $this->courseService->updateCourse(
                $updateCourseByIdRequest->getId(),
                $updateCourseByIdRequest->all()
            )
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/course/{id}/preview",
     *      @OA\Parameter(
     *          parameter="id",
     *          name="id",
     *          required=true,
     *          description="Id курса",
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *          ),
     *          in="path",
     *      ),
     *      tags={"Course"},
     *      summary="Получение информации о курсе предпросмотра",
     *      description="Получение информации о курсе для предпросмотра",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="title", type="string", description="Название курса", example="Курс по космонавтике"),
     *              @OA\Property(property="status", type="string", description="Статус курса (открытый, закрытый, ограниченный)", example="open"),
     *              @OA\Property(property="short_description", type="string", description="Краткое описание курса", example=""),
     *              @OA\Property(property="description", type="string", description="Полное описание курса", example=""),
     *              @OA\Property(property="author_id", type="integer", description="ID пользователя", example="10"),
     *              @OA\Property(property="folder_id", type="integer", description="ID папки, по умолчанию null", example="100"),
     *          ),
     *       )
     *     )
     */
    public function preview(GetPreviewCourseByIdRequest $previewCourseByIdRequest): CoursePreviewResponse
    {
        return new CoursePreviewResponse(
            $this->courseService->getCourseById(
                $previewCourseByIdRequest->getId()
            )
        );
    }

    /**
     * @OA\Delete (
     *      path="/api/v1/course/{id}",
     *      @OA\Parameter(
     *          parameter="id",
     *          name="id",
     *          required=true,
     *          description="Id курса",
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
     *          ),
     *          in="path",
     *      ),
     *      tags={"Course"},
     *      summary="Получение информации о курсе для модератора",
     *      description="Получение информации о курсе для модератора",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="deleted", type="string", example="ok"),
     *          ),
     *       )
     *     )
     */
    public function delete(DeleteCourseByIdRequest $deleteCourseByIdRequest): JsonResponse
    {
        $this->courseService->deleteCourse(
            $deleteCourseByIdRequest->getId()
        );
        return \response()->json(DeleteResource::DELETE_RESPONSE);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/course/catalog/student",
     *      tags={"Course"},
     *      summary="Список курсов для каталога студента",
     *      description="Список курсов для каталога студента",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *          ),
     *       )
     *     )
     */
    public function catalogStudent(GetCourseCatalogRequest $getCourseCatalogRequest):JsonResponse
    {
        $catalog = $this->sortBy(
            $this->courseCatalogService->getStudentCatalog(),
            $getCourseCatalogRequest->getOrderByValue()
        );

        return PaginatorResponse::getResponse(
            new LengthAwarePaginator(
                $catalog,
                $catalog->count(),
                $getCourseCatalogRequest->getLimit(),
                $getCourseCatalogRequest->getPage()
            )
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/course/catalog/moderator",
     *      tags={"Course"},
     *      summary="Список курсов для каталога модератора",
     *      description="Список курсов для каталога модератора",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *          ),
     *       )
     *     )
     */
    public function catalogModerator(GetModeratorCourseCatalogRequest $getCourseCatalogRequest):JsonResponse
    {
        $catalog = $this->sortBy(
            $this->courseCatalogService->getModeratorCatalog(),
            $getCourseCatalogRequest->getOrderByValue()
        );

        return PaginatorResponse::getResponse(
            new LengthAwarePaginator(
                $catalog,
                $catalog->count(),
                $getCourseCatalogRequest->getLimit(),
                $getCourseCatalogRequest->getPage()
            )
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/course/catalog/tags/student",
     *      tags={"Course"},
     *      summary="Список тэгов для каталога студента",
     *      description="Список тэгов для каталога студента",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *          ),
     *       )
     *     )
     */
    public function getCatalogStudentTags():JsonResponse
    {
        return new JsonResponse(
            [
                'data' => [

                ]
            ]
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/course/catalog/tags/moderator",
     *      tags={"Course"},
     *      summary="Список тэгов для каталога модератора",
     *      description="Список тэгов для каталога модератора",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *          ),
     *       )
     *     )
     */
    public function getCatalogModeratorTags():JsonResponse
    {
        return new JsonResponse(
            [
                'data' => [

                ]
            ]
        );
    }
}

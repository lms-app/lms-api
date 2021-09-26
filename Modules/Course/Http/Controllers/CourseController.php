<?php
declare(strict_types=1);

namespace Modules\Course\Http\Controllers;

use App\Http\Controllers\AbstractApiController;
use App\Responses\DeleteResourceResponse;
use App\Responses\PaginatorResponse;
use DateTimeImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Appointment\Http\Responses\AppointmentDataResponse;
use Modules\Appointment\ValueObjects\AppointmentStatus;
use Modules\Course\Entities\Course;
use Modules\Course\Http\Requests\Course\Appointment\CreateCourseAppointmentRequest;
use Modules\Course\Http\Requests\Course\Appointment\GetCourseAppointmentRequest;
use Modules\Course\Http\Requests\Course\CreateCourseRequest;
use Modules\Course\Http\Requests\Course\DeleteCourseByIdRequest;
use Modules\Course\Http\Requests\Course\GetCourseByIdRequest;
use Modules\Course\Http\Requests\Course\GetCourseCatalogRequest;
use Modules\Course\Http\Requests\Course\GetModeratorCourseCatalogRequest;
use Modules\Course\Http\Requests\Course\GetPreviewCourseByIdRequest;
use Modules\Course\Http\Requests\Course\UpdateCourseByIdRequest;
use Modules\Course\Http\Responses\CourseDataResponse;
use Modules\Course\Http\Responses\CoursePreviewResponse;
use Modules\Course\Services\CourseCatalogInterface;
use Modules\Course\Services\CourseServiceInterface;
use Modules\Entity\ValueObjects\EntityType;

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
     *          @OA\JsonContent(ref="#/components/schemas/Course.DataResponse")
     *       )
     *     )
     */
    public function create(CreateCourseRequest $createCourseRequest): CourseDataResponse
    {
        return CourseDataResponse::get(
            $this->courseService->createCourse(
                $createCourseRequest
                    ->merge(
                        [
                            'author_id' => $createCourseRequest->user()->getId(),
                            'entity_type' => EntityType::create(EntityType::TYPE_COURSE)
                        ]
                    )
                    ->all()
            )
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/course/{course_id}",
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
     *          @OA\JsonContent(ref="#/components/schemas/Course.DataResponse")
     *       )
     *     )
     */
    public function getById(GetCourseByIdRequest $courseByIdRequest): CourseDataResponse
    {
        return CourseDataResponse::get(
            $this->courseService->getCourseById(
                $courseByIdRequest->getCourseId()
            )
        );
    }

    /**
     * @OA\Put(
     *      path="/api/v1/course/{course_id}",
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
     *          @OA\JsonContent(ref="#/components/schemas/Course.DataResponse")
     *       )
     *     )
     */
    public function update(UpdateCourseByIdRequest $updateCourseByIdRequest): CourseDataResponse
    {
        return CourseDataResponse::get(
            $this->courseService->updateCourse(
                Course::getById($updateCourseByIdRequest->getCourseId()),
                $updateCourseByIdRequest->all()
            )
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/course/{course_id}/preview",
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
     *      tags={"Course"},
     *      summary="Получение информации о курсе предпросмотра",
     *      description="Получение информации о курсе для предпросмотра",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Course.PreviewDataResponse")
     *       )
     *     )
     */
    public function preview(GetPreviewCourseByIdRequest $previewCourseByIdRequest): CoursePreviewResponse
    {
        return new CoursePreviewResponse(
            $this->courseService->getCourseById(
                $previewCourseByIdRequest->getCourseId()
            )
        );
    }

    /**
     * @OA\Delete (
     *      path="/api/v1/course/{course_id}",
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
     *      tags={"Course"},
     *      summary="Получение информации о курсе для модератора",
     *      description="Получение информации о курсе для модератора",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Resource.DeleteResponse")
     *       )
     *     )
     */
    public function delete(DeleteCourseByIdRequest $deleteCourseByIdRequest): JsonResponse
    {
        $this->courseService->deleteCourse(
            $deleteCourseByIdRequest->getCourseId()
        );

        return DeleteResourceResponse::get();
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

//       $count=0;
//        while ($count != 15) {
//            $newCatalog = $catalog->last();
//            $catalog->push($newCatalog);
//            $count++;
//        }

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

    /**
     * @OA\Post (
     *      path="/api/v1/course/{course_id}/appointment",
     *      tags={"Course", "Apppointment"},
     *      summary="Создаёт назначение для курса",
     *      description="Создаёт назначение для курса",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Appointment.AppointmentDataResponse")
     *       )
     *     )
     */
    public function createAppointment(CreateCourseAppointmentRequest $courseAppointmentRequest):JsonResponse
    {
       $appointment = $this->courseService->createAppointment(
            $courseAppointmentRequest->getUserModel(),
            $this->courseService->getCourseById($courseAppointmentRequest->getCourseId()),
            [
                'date_start' => (new DateTimeImmutable('now'))->format('Y-m-d H:i:s'),
                'date_end' => $courseAppointmentRequest->getDateEnd()->format('Y-m-d H:i:s'),
                'status' => AppointmentStatus::ASSIGNED,
                'attempts_max' => $courseAppointmentRequest->getAttemptsMax(),
            ]
        );

       return AppointmentDataResponse::get($appointment);
    }

    /**
     * @OA\Get (
     *      path="/api/v1/course/appointment/{appointment_id}",
     *      tags={"Course", "Apppointment"},
     *      summary="Получает назначение для курса",
     *      description="Получает назначение для курса",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Appointment.AppointmentDataResponse")
     *       )
     *     )
     */
    public function getAppointment(GetCourseAppointmentRequest $getCourseAppointmentRequest):JsonResponse
    {
       return AppointmentDataResponse::get(
           $this->courseService->getAppointmentById(
               $getCourseAppointmentRequest->getAppointmentId()
           )
       );
    }

    /**
     * @OA\Post  (
     *      path="/api/v1/course/appointment/{appointment_id}/start",
     *      tags={"Course", "Apppointment"},
     *      summary="Активирует назначение для курса",
     *      description="Активирует назначение для курса",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Appointment.AppointmentDataResponse")
     *       )
     *     )
     */
    public function startAppointment(GetCourseAppointmentRequest $getCourseAppointmentRequest):JsonResponse
    {
       return AppointmentDataResponse::get(
           $this->courseService->startAppointment(
               $this->courseService->getAppointmentById(
                   $getCourseAppointmentRequest->getAppointmentId()
               )
           )
       );
    }
}

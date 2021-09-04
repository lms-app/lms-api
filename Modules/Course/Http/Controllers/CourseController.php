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
use Modules\Course\Resources\CreateCourseResource;
use Modules\Course\Resources\GetCoursePreviewResource;
use Modules\Course\Resources\GetCourseResource;
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

    public function create(CreateCourseRequest $createCourseRequest): CreateCourseResource
    {
        return new CreateCourseResource(
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

    public function getById(GetCourseByIdRequest $courseByIdRequest): JsonResponse
    {
        $course = $this->courseService->getCourseById(
            $courseByIdRequest->getId()
        );

        $entity = $course->getEntity();

        return new JsonResponse(
            [
                'data' => [
                    'author_id' => $entity->getAttribute('author_id'),
                    'title' => $entity->getAttribute('title'),
                    'status' => $entity->getAttribute('status'),
                    'short_description' => $entity->getAttribute('short_description'),
                    'description' => $entity->getAttribute('description'),
                    'attempts_count' => $course->getAttribute('attempts_count'),
                    'after_finished_view_element_access' => $course->getAttribute('after_finished_view_element_access'),
                    'section_sequential_passage' => $course->getAttribute('section_sequential_passage'),
                    'members_block' => [
                        'access_date' => [],
                        'member_enterprises' => [],
                        'member_excludes' => [],
                        'member_groups' => [],
                        'member_users' => [],
                    ]
                ]
            ]
        );
    }

    public function update(UpdateCourseByIdRequest $updateCourseByIdRequest): GetCourseResource
    {
        return new GetCourseResource(
            $this->courseService->updateCourse(
                $updateCourseByIdRequest->getId(),
                $updateCourseByIdRequest->all()
            )
        );
    }

    public function preview(GetPreviewCourseByIdRequest $previewCourseByIdRequest): GetCoursePreviewResource
    {
        return new GetCoursePreviewResource(
            $this->courseService->getCourseById(
                $previewCourseByIdRequest->getId()
            )
        );
    }

    public function delete(DeleteCourseByIdRequest $deleteCourseByIdRequest): JsonResponse
    {
        $this->courseService->deleteCourse(
            $deleteCourseByIdRequest->getId()
        );
        return \response()->json(DeleteResource::DELETE_RESPONSE);
    }

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

    public function getCatalogStudentTags():JsonResponse
    {
        return new JsonResponse(
            [
                'data' => [

                ]
            ]
        );
    }

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

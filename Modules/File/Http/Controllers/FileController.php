<?php
declare(strict_types=1);

namespace Modules\File\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\File\Exceptions\NoUploadedFilesException;
use Modules\File\Http\Requests\CreateFileRequest;
use Modules\File\Services\CreateFileInterface;

final class FileController extends Controller
{
    private CreateFileInterface $createFileService;

    public function __construct(CreateFileInterface $createFileService)
    {
        $this->createFileService = $createFileService;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/file",
     *      tags={"File"},
     *      summary="Создание файла",
     *      description="Создание файла",
     *     	@OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="file[]",
     *                      description="Файл",
     *                      type="file",
     *                      format="binary"
     *                   ),
     *               ),
     *           ),
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="original_name", type="string", description="Название переданного файла"),
     *              @OA\Property(property="file_name", type="string", description="Название сгенерированного файла"),
     *              @OA\Property(property="file_path", type="string", description="Внутренний путь сгенерированного файла"),
     *              @OA\Property(property="mime_type", type="string", description="MIME type"),
     *              @OA\Property(property="size", type="string", description="Размер файла"),
     *              @OA\Property(property="public_path", type="string", description="Путь файла"),
     *          ),
     *       )
     *     )
     * @throws NoUploadedFilesException
     */
    public function create(CreateFileRequest $createFileRequest):JsonResponse
    {
        if (count($createFileRequest->file) === 0) {
            throw NoUploadedFilesException::becauseFileNotUploaded();
        }

        return new JsonResponse(
            [
                'data' => [
                    $this->createFileService->createFiles(...$createFileRequest->file)
                ]
            ]
        );
    }
}

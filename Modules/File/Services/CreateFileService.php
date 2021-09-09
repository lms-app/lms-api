<?php
declare(strict_types=1);


namespace Modules\File\Services;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Modules\File\Entities\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class CreateFileService implements CreateFileInterface
{
    private const FILE_PATH = '/uploads';

    public function createFiles(UploadedFile ...$files): Collection
    {
        $createdFiles = [];

        foreach ($files as $file) {
            /** @var string $filePath */
            $filePath = Storage::disk('s3')->put(self::FILE_PATH, $file);
            $fileParts = explode('/', $filePath);
            $fileName = array_pop($fileParts);
            $createdFiles[] =  File::query()->create(
                [
                    'original_name' => $file->getClientOriginalName(),
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                    'public_path' => Storage::disk('s3')->url($filePath),
                ]
            );
        }

        return collect($createdFiles);
    }
}

<?php
declare(strict_types=1);

namespace Modules\File\Services;

use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface CreateFileInterface
{
    public function createFiles(UploadedFile ...$files):Collection;
}

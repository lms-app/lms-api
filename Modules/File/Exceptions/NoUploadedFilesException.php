<?php
declare(strict_types=1);

namespace Modules\File\Exceptions;

use Exception;

final class NoUploadedFilesException extends Exception
{
    public static function becauseFileNotUploaded():self
    {
        return new self('No files was uploaded');
    }
}

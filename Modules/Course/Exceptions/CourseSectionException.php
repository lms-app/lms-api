<?php
declare(strict_types=1);

namespace Modules\Course\Exceptions;

use Exception;

final class CourseSectionException extends Exception
{
    public static function becauseSectionIsNotExist():self
    {
        return new self('Course section is not exist');
    }
}

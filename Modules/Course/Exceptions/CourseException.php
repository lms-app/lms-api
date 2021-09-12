<?php
declare(strict_types=1);

namespace Modules\Course\Exceptions;

use Exception;

final class CourseException extends Exception
{
    public static function becauseCourseIsNotExist():self
    {
        return new self('Course is not exist');
    }
}

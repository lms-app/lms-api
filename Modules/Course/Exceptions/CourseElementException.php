<?php
declare(strict_types=1);

namespace Modules\Course\Exceptions;

use Exception;

final class CourseElementException extends Exception
{
    public static function becauseCourseElementIsNotExist():self
    {
        return new self('Course element is not exist');
    }
}

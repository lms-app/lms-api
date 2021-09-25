<?php
declare(strict_types=1);

namespace Modules\Test\Exceptions;

use Exception;

final class TestException extends Exception
{
    public static function becauseTestIsNotExist():self
    {
        return new self('Test is not exist');
    }
}

<?php
declare(strict_types=1);

namespace Modules\User\Exceptions;

final class UserNotFoundException extends \Exception
{
    public static function becauseUserIsNotFoundByLogin():self
    {
        return new self('user is not found by login');
    }
}

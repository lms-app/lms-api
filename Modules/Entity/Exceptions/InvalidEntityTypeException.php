<?php
declare(strict_types=1);

namespace Modules\Entity\Exceptions;

final class InvalidEntityTypeException extends \LogicException
{
    public static function becauseEntityTypeIsInvalid():self
    {
        return new self('Entity type is invalid');
    }
}

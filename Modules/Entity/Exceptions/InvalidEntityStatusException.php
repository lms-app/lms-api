<?php
declare(strict_types=1);

namespace Modules\Entity\Exceptions;

final class InvalidEntityStatusException extends \LogicException
{
    public const ENTITY_STATUS_INVALID_MESSAGE = 'Entity status is invalid';

    public static function becauseEntityStatusIsInvalid():self
    {
        return new self(self::ENTITY_STATUS_INVALID_MESSAGE);
    }
}

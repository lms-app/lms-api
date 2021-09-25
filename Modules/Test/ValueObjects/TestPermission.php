<?php

declare(strict_types=1);

namespace Modules\Test\ValueObjects;

final class TestPermission
{
    public const SUBJECT = 'TEST';

    public const CREATE = self::SUBJECT . '.CREATE';
    public const SEE_AS_ADMINISTRATOR = self::SUBJECT . '.SEE_AS_ADMINISTRATOR';
    public const SEE_AS_MODERATOR = self::SUBJECT . '.SEE_AS_MODERATOR';
    public const EDIT_AS_ADMINISTRATOR = self::SUBJECT . '.EDIT_AS_ADMINISTRATOR';
    public const EDIT_AS_MODERATOR = self::SUBJECT . '.EDIT_AS_MODERATOR';
    public const DELETE_AS_ADMINISTRATOR = self::SUBJECT . '.DELETE_AS_ADMINISTRATOR';
    public const DELETE_AS_MODERATOR = self::SUBJECT . '.DELETE_AS_MODERATOR';
    public const SEE_AS_STUDENT = self::SUBJECT . '.SEE_AS_STUDENT';
    public const PASS_AS_STUDENT = self::SUBJECT . '.PASS_AS_STUDENT';
}

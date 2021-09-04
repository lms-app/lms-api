<?php
declare(strict_types=1);

namespace Modules\Authorization\ValueObjects;

final class Role
{
    public const ADMINISTRATOR = 'Administrator';
    public const MODERATOR = 'Moderator';
    public const STUDENT = 'Student';
}

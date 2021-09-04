<?php

declare(strict_types=1);

namespace Modules\Course\ValueObjects;

final class CourseFolderPermission
{
    private const PREFIX = 'COURSE_FOLDER';

    public const CREATE = self::PREFIX . '.CREATE';
    public const SEE_AS_ADMINISTRATOR = self::PREFIX . '.SEE_AS_ADMINISTRATOR';
    public const SEE_AS_MODERATOR = self::PREFIX . '.SEE_AS_MODERATOR';
    public const EDIT_AS_ADMINISTRATOR = self::PREFIX . '.EDIT_AS_ADMINISTRATOR';
    public const EDIT_AS_MODERATOR = self::PREFIX . '.EDIT_AS_MODERATOR';
    public const DELETE_AS_ADMINISTRATOR = self::PREFIX . '.DELETE_AS_ADMINISTRATOR';
    public const DELETE_AS_MODERATOR = self::PREFIX . '.DELETE_AS_MODERATOR';
    public const SEE_AS_STUDENT = self::PREFIX . '.SEE_AS_STUDENT';
    public const PASS_AS_STUDENT = self::PREFIX . '.PASS_AS_STUDENT';
}

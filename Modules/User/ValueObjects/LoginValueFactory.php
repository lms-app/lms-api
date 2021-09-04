<?php
declare(strict_types=1);


namespace Modules\User\ValueObjects;


final class LoginValueFactory
{
    private const VALUE_TYPES = [
        'email',
        'phone',
    ];

    public static function createByType(string $type, string $value):LoginValueInterface
    {
        if (!in_array($type, self::VALUE_TYPES, true)) {
            throw new \LogicException('Login VO type is not exist');
        }

        if ($type === Email::TYPE) {
            return Email::create($value);
        } elseif ($type === Phone::TYPE) {
            return Phone::create($value);
        }

        throw new \LogicException('Type not exist');
    }
}

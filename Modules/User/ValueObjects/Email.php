<?php
declare(strict_types=1);

namespace Modules\User\ValueObjects;

final class Email implements \JsonSerializable, LoginValueInterface
{
    private string $email;
    public const TYPE = 'email';

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function create(string $email):self
    {
        return new self($email);
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function jsonSerialize():string
    {
        return $this->__toString();
    }

    public function get(): string
    {
        return $this->__toString();
    }

    public function type(): string
    {
        return self::TYPE;
    }
}

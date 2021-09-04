<?php
declare(strict_types=1);

namespace Modules\User\ValueObjects;

final class Phone implements \JsonSerializable, LoginValueInterface
{
    private string $phone;
    public const TYPE = 'email';

    public function __construct(string $phone)
    {
        $this->phone = $phone;
    }

    public static function create(string $phone):self
    {
        return new self($phone);
    }

    public function __toString(): string
    {
        return $this->phone;
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

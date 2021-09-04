<?php
declare(strict_types=1);

namespace Modules\Authentication\ValueObjects;

final class LoginKey implements \JsonSerializable
{
    private string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public static function create(string $key):self
    {
        return new self($key);
    }

    public function __toString(): string
    {
        return $this->key;
    }

    public function jsonSerialize():string
    {
        return $this->key;
    }
}

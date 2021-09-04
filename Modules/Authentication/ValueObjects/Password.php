<?php
declare(strict_types=1);

namespace Modules\Authentication\ValueObjects;

final class Password implements \JsonSerializable
{
    private string $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public static function create(string $password):self
    {
        return new self($password);
    }

    public function __toString(): string
    {
        return $this->password;
    }

    public function jsonSerialize():string
    {
        return $this->password;
    }
}

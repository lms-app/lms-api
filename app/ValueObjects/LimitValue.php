<?php
declare(strict_types=1);

namespace App\ValueObjects;

final class LimitValue
{
    public const LIMIT_DEFAULT = 10;
    public const LIMIT_FOLDER_DEFAULT = 9;

    private int $limit;

    public function __construct(int $limit = self::LIMIT_DEFAULT)
    {
        $this->limit = $limit;
    }

    public static function create(int $limit = self::LIMIT_DEFAULT):self
    {
        return new self($limit);
    }

    public function get(): int
    {
        return $this->limit;
    }
}

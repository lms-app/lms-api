<?php
declare(strict_types=1);

namespace App\ValueObjects;

final class OrderByValue
{
    public CONST DIRECTION_DESC = 'desc';
    public CONST DIRECTION_ASC = 'asc';

    public const CREATED_AT = 'created_at';

    private string $orderBy;
    private string $direction;

    public function __construct(string $sortBy, string $direction = self::DIRECTION_ASC)
    {
        $this->orderBy = $sortBy;
        $this->direction = $direction;
    }

    public static function create(string $sortBy, string $direction = self::DIRECTION_ASC):self
    {
        return new self($sortBy, $direction);
    }

    public function direction():string
    {
        return $this->direction;
    }

    public function field():string
    {
        return $this->orderBy;
    }

    public function isDirectionDesc():bool
    {
        return $this->direction === self::DIRECTION_DESC;
    }
}

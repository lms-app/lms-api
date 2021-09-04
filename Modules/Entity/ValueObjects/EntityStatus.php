<?php
declare(strict_types=1);

namespace Modules\Entity\ValueObjects;

use Modules\Entity\Exceptions\InvalidEntityStatusException;

final class EntityStatus implements \JsonSerializable
{
    public const STATUS_OPEN = 'open';
    public const STATUS_CLOSED = 'close';
    public const STATUS_ACTIVE_CLOSED = 'limited';

    private const ENTITY_STATUSES = [
        self::STATUS_OPEN,
        self::STATUS_CLOSED,
        self::STATUS_ACTIVE_CLOSED,
    ];

    private string $entityType;

    public function __construct(string $entityType)
    {
        $this->entityType = $entityType;
        $this->validate();
    }

    private function validate():void
    {
        if (!in_array($this->entityType, self::ENTITY_STATUSES)) {
            throw InvalidEntityStatusException::becauseEntityStatusIsInvalid();
        }
    }

    public static function create(string $entityType):self{
        return new self($entityType);
    }

    public function get():string
    {
        return $this->entityType;
    }

    public function __toString(): string
    {
        return $this->entityType;
    }

    public function jsonSerialize()
    {
        return $this->entityType;
    }
}

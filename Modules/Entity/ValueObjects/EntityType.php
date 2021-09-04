<?php
declare(strict_types=1);

namespace Modules\Entity\ValueObjects;

use Modules\Entity\Exceptions\InvalidEntityTypeException;

final class EntityType implements \JsonSerializable
{
    public const TYPE_COURSE = 'course';

    private const ENTITY_TYPES = [
        self::TYPE_COURSE
    ];

    private string $entityType;

    public function __construct(string $entityType)
    {
        $this->entityType = $entityType;
        $this->validate();
    }

    private function validate():void
    {
        if (!in_array($this->entityType, self::ENTITY_TYPES)) {
            throw InvalidEntityTypeException::becauseEntityTypeIsInvalid();
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

    public function getObject():string
    {
        return ucfirst($this->entityType);
    }
}

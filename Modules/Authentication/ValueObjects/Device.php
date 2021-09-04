<?php
declare(strict_types=1);


namespace Modules\Authentication\ValueObjects;


final class Device
{
    private ?string $deviceId;
    private const TYPE_BROWSER = 'browser';

    public function __construct(?string $deviceId = null)
    {
        $this->deviceId = $deviceId;

        if ($deviceId === null) {
            $this->deviceId = self::TYPE_BROWSER;
        }
    }

    public function __toString(): string
    {
        return $this->deviceId;
    }

    public static function create(?string $deviceId):self
    {
        return new self($deviceId);
    }

    public function isMobileApp():bool
    {
        return $this->deviceId !== null;
    }
}

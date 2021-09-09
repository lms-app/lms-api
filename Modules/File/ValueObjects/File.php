<?php
declare(strict_types=1);

namespace Modules\File\ValueObjects;

final class File
{
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public static function create(string $fileName):self
    {
        return new self($fileName);
    }

    public function getFileName():string
    {
        return $this->fileName;
    }
}

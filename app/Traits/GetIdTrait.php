<?php
declare (strict_types=1);


namespace App\Traits;


trait GetIdTrait
{
    public function getId():int
    {
        return (int) $this->id;
    }
}

<?php

namespace Modules\User\ValueObjects;

interface LoginValueInterface
{
    public function get():string;
    public function type():string;
}

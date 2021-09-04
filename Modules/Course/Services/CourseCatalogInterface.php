<?php

namespace Modules\Course\Services;

use Illuminate\Support\Collection;

interface CourseCatalogInterface
{
    public function getStudentCatalog():Collection;
    public function getModeratorCatalog():Collection;
}

<?php
declare(strict_types=1);

namespace Modules\Course\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class CourseTestCase extends TestCase
{
    protected const SORT_ORDER = 200;
    protected const PASS_SCORE = 1000;
    protected const TITLE = 'Секция видео';
    protected const DESCRIPTION = 'Описание секции';
    protected const ADMIN_NOTES = 'Заметки админа';
    protected const FINISH_COURSE_ON_FAIL = true;
    protected const SHOW_RESULTS = true;
    protected const SEQUENTIAL_PASSAGE = true;
    protected const ATTEMPT_COUNT = 10;
}

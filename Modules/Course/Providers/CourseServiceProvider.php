<?php
declare(strict_types=1);

namespace Modules\Course\Providers;

use App\Traits\RegisterConfigTrait;
use Illuminate\Support\ServiceProvider;
use Modules\Course\Services\CourseCatalogInterface;
use Modules\Course\Services\CourseCatalogService;
use Modules\Course\Services\CourseElementService;
use Modules\Course\Services\CourseElementServiceInterface;
use Modules\Course\Services\CourseSectionService;
use Modules\Course\Services\CourseSectionServiceInterface;
use Modules\Course\Services\CourseServiceInterface;
use Modules\Course\Services\CreateCourseInterface;
use Modules\Course\Services\CourseService;
use Modules\Course\Services\GetCourseInterface;
use Modules\Course\Services\GetCourseService;

final class CourseServiceProvider extends ServiceProvider
{
    use RegisterConfigTrait;

    private string $moduleName = 'Course';

    private string $moduleNameLower = 'course';

    public function boot():void
    {
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    public function register()
    {
        $this->app->bind(CourseServiceInterface::class, CourseService::class);
        $this->app->bind(CourseCatalogInterface::class, CourseCatalogService::class);
        $this->app->bind(CourseSectionServiceInterface::class, CourseSectionService::class);
        $this->app->bind(CourseElementServiceInterface::class, CourseElementService::class);
        $this->app->register(RouteServiceProvider::class);
    }

    public function provides()
    {
        return [];
    }
}

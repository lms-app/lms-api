<?php
declare(strict_types=1);

namespace Modules\Entity\Providers;

use App\Traits\RegisterConfigTrait;
use Illuminate\Support\ServiceProvider;
use Modules\Entity\Services\EntityService;
use Modules\Entity\Services\EntityServiceInterface;
use Modules\Entity\Services\GetEntityService;
use Modules\Entity\Services\GetEntityServiceInterface;

final class EntityServiceProvider extends ServiceProvider
{
    use RegisterConfigTrait;

    protected string $moduleName = 'Entity';

    protected string $moduleNameLower = 'entity';

    public function boot():void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(EntityServiceInterface::class, EntityService::class);
    }

    public function registerTranslations():void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    public function provides()
    {
        return [];
    }
}

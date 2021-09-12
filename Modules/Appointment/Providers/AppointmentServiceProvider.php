<?php
declare(strict_types=1);

namespace Modules\Appointment\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Appointment\Services\AppointmentService;
use Modules\Appointment\Services\AppointmentServiceInterface;

final class AppointmentServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Appointment';

    protected string $moduleNameLower = 'appointment';

    public function boot():void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(AppointmentServiceInterface::class, AppointmentService::class);
    }

    protected function registerConfig():void
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
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

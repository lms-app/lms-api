<?php
declare(strict_types=1);

namespace Modules\Authentication\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Authentication\Http\Controllers\AuthenticationAbstractApiController;
use Modules\Authentication\Http\Controllers\AuthenticationControllerInterface;
use Modules\Authentication\Services\LoginService;
use Modules\Authentication\Services\LoginServiceInterface;
use Modules\Authentication\Services\PasswordService;
use Modules\Authentication\Services\PasswordServiceInterface;

final class AuthenticationServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Authentication';

    protected string $moduleNameLower = 'authentication';

    public function boot():void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(LoginServiceInterface::class, LoginService::class);
        $this->app->bind(PasswordServiceInterface::class, PasswordService::class);
        $this->app->bind(AuthenticationControllerInterface::class, AuthenticationAbstractApiController::class);
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

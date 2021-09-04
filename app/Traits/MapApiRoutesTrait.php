<?php
declare(strict_types=1);


namespace App\Traits;


use Illuminate\Support\Facades\Route;

trait MapApiRoutesTrait
{
    private function mapApiRoutes():void
    {
        Route::prefix(static::API_PREFIX)
            ->middleware(static::MIDDLEWARES)
            ->namespace($this->moduleNamespace)
            ->group(module_path(static::MODULE_NAME, '/Routes/api.php'));
    }

    public function boot()
    {
        parent::boot();
    }

    public function map():void
    {
        $this->mapApiRoutes();
    }
}

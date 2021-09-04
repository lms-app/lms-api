<?php
declare(strict_types=1);

namespace Modules\Catalog\Providers;

use App\Traits\MapApiRoutesTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    private string $moduleNamespace = 'Modules\Catalog\Http\Controllers';

    use MapApiRoutesTrait;
    private const API_PREFIX = 'api/v1/catalog';
    private const MODULE_NAME = 'Catalog';
    private const MIDDLEWARES = [
        'api',
        'auth:sanctum',
    ];
}

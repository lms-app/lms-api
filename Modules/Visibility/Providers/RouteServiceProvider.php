<?php
declare(strict_types=1);

namespace Modules\Visibility\Providers;

use App\Traits\MapApiRoutesTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    private string $moduleNamespace = 'Modules\Visibility\Http\Controllers';

    use MapApiRoutesTrait;
    private const API_PREFIX = 'api/v1/visibility';
    private const MODULE_NAME = 'Visibility';
    private const MIDDLEWARES = [
        'api',
        'auth:sanctum',
    ];
}

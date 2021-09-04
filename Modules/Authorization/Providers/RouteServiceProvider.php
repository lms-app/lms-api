<?php
declare(strict_types=1);

namespace Modules\Authorization\Providers;

use App\Traits\MapApiRoutesTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    private string $moduleNamespace = 'Modules\Authorization\Http\Controllers';

    use MapApiRoutesTrait;
    private const API_PREFIX = 'api/v1/authorization';
    private const MODULE_NAME = 'Authorization';
    private const MIDDLEWARES = [
        'api',
        'auth:sanctum',
    ];
}

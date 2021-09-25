<?php
declare(strict_types=1);

namespace Modules\Test\Providers;

use App\Traits\MapApiRoutesTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    protected string $moduleNamespace = 'Modules\Test\Http\Controllers';

    use MapApiRoutesTrait;
    private const API_PREFIX = 'api/v1/test';
    private const MODULE_NAME = 'Test';
    private const MIDDLEWARES = [
        'api',
        'auth:sanctum',
    ];
}

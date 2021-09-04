<?php
declare(strict_types=1);

namespace Modules\Tags\Providers;

use App\Traits\MapApiRoutesTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    private string $moduleNamespace = 'Modules\Tags\Http\Controllers';

    use MapApiRoutesTrait;
    private const API_PREFIX = 'api/v1/tags';
    private const MODULE_NAME = 'Tags';
    private const MIDDLEWARES = [
        'auth:sanctum',
        'api'
    ];
}

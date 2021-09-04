<?php
declare(strict_types=1);

namespace Modules\Group\Providers;

use App\Traits\MapApiRoutesTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    private string $moduleNamespace = 'Modules\Group\Http\Controllers';

    use MapApiRoutesTrait;
    private const API_PREFIX = 'api/v1/group';
    private const MODULE_NAME = 'Group';
    private const MIDDLEWARES = [
        'api',
        'auth:sanctum',
    ];
}

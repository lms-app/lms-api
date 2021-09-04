<?php
declare(strict_types=1);

namespace Modules\Authentication\Providers;

use App\Traits\MapApiRoutesTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    private string $moduleNamespace = 'Modules\Authentication\Http\Controllers';

    use MapApiRoutesTrait;
    private const API_PREFIX = 'api/v1/authentication';
    private const MODULE_NAME = 'Authentication';
    private const MIDDLEWARES = [
        'api',
    ];
}

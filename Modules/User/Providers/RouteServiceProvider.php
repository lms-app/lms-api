<?php
declare(strict_types=1);

namespace Modules\User\Providers;

use App\Traits\MapApiRoutesTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    private string $moduleNamespace = 'Modules\User\Http\Controllers';

    use MapApiRoutesTrait;
    private const API_PREFIX = 'api/v1/user';
    private const MODULE_NAME = 'User';
    private const MIDDLEWARES = [
        'api',
        'auth:sanctum',
    ];
}
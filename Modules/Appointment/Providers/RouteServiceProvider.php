<?php
declare(strict_types=1);

namespace Modules\Appointment\Providers;

use App\Traits\MapApiRoutesTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    private string $moduleNamespace = 'Modules\Appointment\Http\Controllers';

    use MapApiRoutesTrait;
    private const API_PREFIX = 'api/v1/appointment';
    private const MODULE_NAME = 'Appointment';
    private const MIDDLEWARES = [
        'api',
        'auth:sanctum',
    ];
}

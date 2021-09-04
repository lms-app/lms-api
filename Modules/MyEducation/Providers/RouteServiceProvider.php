<?php
declare(strict_types=1);

namespace Modules\MyEducation\Providers;

use App\Traits\MapApiRoutesTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    private string $moduleNamespace = 'Modules\MyEducation\Http\Controllers';

    use MapApiRoutesTrait;
    private const API_PREFIX = 'api/v1/education';
    private const MODULE_NAME = 'MyEducation';
    private const MIDDLEWARES = [
        'api',
        'auth:sanctum',
    ];
}

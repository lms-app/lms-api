<?php
declare(strict_types=1);

namespace Modules\File\Providers;

use App\Traits\MapApiRoutesTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    private string $moduleNamespace = 'Modules\File\Http\Controllers';

    use MapApiRoutesTrait;
    private const API_PREFIX = 'api/v1/file';
    private const MODULE_NAME = 'File';
    private const MIDDLEWARES = [
        'api',
        'auth:sanctum',
    ];
}

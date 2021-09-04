<?php
declare(strict_types=1);

namespace Modules\Folder\Providers;

use App\Traits\MapApiRoutesTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    private string $moduleNamespace = 'Modules\Folder\Http\Controllers';

    use MapApiRoutesTrait;
    private const API_PREFIX = 'api/v1/folder';
    private const MODULE_NAME = 'Folder';
    private const MIDDLEWARES = [
        'api',
        'auth:sanctum',
    ];
}

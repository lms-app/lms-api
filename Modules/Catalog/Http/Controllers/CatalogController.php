<?php
declare(strict_types=1);

namespace Modules\Catalog\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

final class CatalogController extends Controller
{
    public function countForStudent():JsonResponse
    {
        return new JsonResponse(
            [
                'data' => [
                   [
                       'object' => 'Polls',
                       'count' => 0,
                   ],
                   [
                       'object' => 'Events',
                       'count' => 0,
                       'is_new' => false,
                   ],
                   [
                       'object' => 'Program',
                       'count' => 0,
                       'is_new' => false,
                   ],
                   [
                       'object' => 'Test',
                       'count' => 0,
                       'is_new' => false,
                   ],
                   [
                       'object' => 'Courses',
                       'count' => 0,
                       'is_new' => false,
                   ],
                   [
                       'object' => 'Forms',
                       'count' => 0,
                       'is_new' => false,
                   ],
                ]
            ]
        );
    }

    public function countForModerator():JsonResponse
    {
        return new JsonResponse(
            [
                'data' => [
                    [
                        'object' => 'Polls',
                        'count' => 0,
                    ],
                    [
                        'object' => 'Events',
                        'count' => 0,
                        'is_new' => false,
                    ],
                    [
                        'object' => 'Program',
                        'count' => 0,
                        'is_new' => false,
                    ],
                    [
                        'object' => 'Test',
                        'count' => 0,
                        'is_new' => false,
                    ],
                    [
                        'object' => 'Courses',
                        'count' => 0,
                        'is_new' => false,
                    ],
                    [
                        'object' => 'Forms',
                        'count' => 0,
                        'is_new' => false,
                    ],
                ]
            ]
        );
    }
}

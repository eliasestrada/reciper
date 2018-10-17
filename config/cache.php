<?php

return [

    'default' => env('CACHE_DRIVER', 'file'),

    'stores' => [
        'apc' => [
            'driver' => 'apc',
        ],
        'array' => [
            'driver' => 'array',
        ],
        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
        ],
        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
        ],
    ],

    'prefix' => env('CACHE_PREFIX', 'C'),

    // Timing for certain parts in app in minutes
    'timing' => [
        'popular_recipes' => 10,
        'random_recipes' => 2,
        'search_suggest' => 60,
    ],
];

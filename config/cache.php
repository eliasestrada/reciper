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
            'driver' => 'phpredis',
            'connection' => 'default',
        ],
    ],

    'prefix' => env(
        'CACHE_PREFIX',
        str_slug(env('APP_NAME', 'laravel'), '_') . '_cache'
    ),

    // Timing for certain parts in app in minutes
    'timing' => [
        'popular_recipes' => 10,
        'random_recipes' => 2,
        # 'title_footer' set to remember forever
    ],
];

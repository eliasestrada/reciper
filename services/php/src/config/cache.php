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

    'prefix' => env('CACHE_PREFIX', null),

    // Timing for certain parts in app in minutes
    'timing' => [
        'popular_recipes' => 10 * 60, // 10 min
        'random_recipes' => 10 * 60, // 10 min
        'help_categories' => 10 * 60,  // 10 min
        'help_list' => 10 * 60, // 10 min
        'user_changed_email' => 10080 * 60, // 1 week
        'user_statistics_data' => 180 * 60, // 3 hour
    ],
];

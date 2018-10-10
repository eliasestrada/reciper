<?php

return [
    // Default Database Connection Name
    'default' => env('DB_CONNECTION', 'mysql'),

    // Database Connections
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', ''),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
    ],

    // Migration Repository Table
    'migrations' => 'migrations',

    'redis' => [
        'default' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => '{default}',
            'retry_after' => 90,
            'block_for' => 5,
        ],
    ],
];

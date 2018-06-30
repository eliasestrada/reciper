<?php

use Arcanedev\LogViewer\Contracts\Utilities\Filesystem;

return [

    /** Log files storage path */
    'storage-path' => storage_path('logs'),

    /** Log files pattern */
    'pattern' => [
        'prefix' => Filesystem::PATTERN_PREFIX, // 'laravel-'
        'date' => Filesystem::PATTERN_DATE, // '[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]'
        'extension' => Filesystem::PATTERN_EXTENSION, // '.log'
    ],

    /**
	 * Supported locales:
	 * auto', 'ar', 'bg', 'de', 'en', 'es', 'et', 'fa', 'fr', 'hu', 'hy', 'id', 'it',
	 * 'ja', 'ko', 'nl', pl', 'pt-BR', 'ro', 'ru', 'sv', 'th', 'tr', 'zh-TW', 'zh'
	 */

    'locale' => 'auto',

    /**
	 * Supported themes: 'bootstrap-3', 'bootstrap-4', 'custom-theme'
	 * Make your own theme by adding a folder to the views directory and specifying it here.
	 */
    'theme' => 'custom-theme',

    /** Route settings */
    'route' => [
        'enabled' => true,

        'attributes' => [
            'prefix' => 'log-viewer',

            'middleware' => env('ARCANEDEV_LOGVIEWER_MIDDLEWARE') ? explode(',', env('ARCANEDEV_LOGVIEWER_MIDDLEWARE')) : null,
        ],
    ],

	/**
	 * Log entries per page
	 * This defines how many logs & entries are displayed per page
	 */
    'per-page' => 30,

    /** LogViewer's Facade */
    'facade' => 'LogViewer',

    /** Download settings */
    'download' => [
        'prefix' => 'laravel-',
        'extension' => 'log',
    ],

    /** Menu settings */
    'menu'  => [
        'filter-route' => 'log-viewer::logs.filter',
        'icons-enabled' => true,
    ],

    /** Colors */
    'colors' =>  [
        'levels'    => [
            'empty' => '#D1D1D1',
            'all' => '#8A8A8A',
            'emergency' => '#B71C1C',
            'alert' => '#D32F2F',
            'critical'  => '#F44336',
            'error' => '#FF5722',
            'warning' => '#FF9100',
            'notice' => '#4CAF50',
            'info' => '#1976D2',
            'debug' => '#90CAF9',
        ],
    ],

    /** Strings to highlight in stack trace */
    'highlight' => [
        '^#\d+',
        '^Stack trace:',
    ],

];
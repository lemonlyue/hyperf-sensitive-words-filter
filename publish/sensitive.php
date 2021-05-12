<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://github.com/lemonlyue/hyperf-sensitive-words-filter
 * @document https://github.com/lemonlyue/hyperf-sensitive-words-filter/blob/main/README.md
 * @license  https://github.com/lemonlyue/hyperf-sensitive-words-filter/blob/main/LICENSE
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Default Sensitive Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching library. This connection is used when another is
    | not explicitly specified when executing a given caching function.
    |
    */
    'default' => env('SENSITIVE_CACHE_DRIVER', 'array'),

    /*
    |--------------------------------------------------------------------------
    | Sensitive Cache driver
    |--------------------------------------------------------------------------
    |
    | Supported drivers: "array", "file", "redis"
    |
    */
    'driver' => [
        'array' => [
            'drive' => 'array',
            'serialize' => false,
        ],
        'redis' => [
            'drive' => 'redis',
            'connection' => 'default',
        ],
        'file' => [
            'driver' => 'file',
            'path' => BASE_PATH . '/storage/cache/data',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Sensitive words file
    |--------------------------------------------------------------------------
    |
    | Supported file type: "txt"
    */
    'file' => [
        'type' => 'txt',
        'path' => ''
    ]
];
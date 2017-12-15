<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Cache Store
     |--------------------------------------------------------------------------
     |
     | This option enables\disables the cache store. When enabled the default
     | connection will be used. Otherwise, it will fallback to the "array"
     | connection.
     |
     */

    'enabled' => true,

    /*
     |--------------------------------------------------------------------------
     | Default Cache Store
     |--------------------------------------------------------------------------
     |
     | This option controls the default cache connection that gets used while
     | using this caching library.
     |
     | Supported: "array", "file"
     |
     */

    'default' => 'file',

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers.
    |
    */

    'stores' => [
        'array' => [
            'driver' => 'array',
        ],
        'file' => [
            'driver' => 'file',
            'path'   => __DIR__ . '/../cache',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Key Lifetime
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of minutes that you wish the cache
    | key to live in cache before expiring.
    |
    */

    'lifetime' => 120,
];
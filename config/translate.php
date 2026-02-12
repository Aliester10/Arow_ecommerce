<?php

return [
    'supported_locales' => ['id', 'en'],

    'source' => env('TRANSLATE_SOURCE', 'id'),

    'cache_version' => env('TRANSLATE_CACHE_VERSION', 'v2'),

    'url' => env('TRANSLATE_URL', 'https://libretranslate.com/translate'),

    'key' => env('TRANSLATE_KEY'),

    'timeout' => env('TRANSLATE_TIMEOUT', 4),
];

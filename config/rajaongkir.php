<?php

return [
    'api_key' => env('API_CO_ID_KEY', ''),
    'base_url' => 'https://use.api.co.id',
    'origin_city' => env('RAJAONGKIR_ORIGIN_CITY', '3172051003'), // Fallback to Pademangan, Jakarta 3172051003 for testing
    'couriers' => explode(',', env('RAJAONGKIR_COURIERS', 'jne,sicepat,jnt,pos')),
];

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | RajaOngkir API Key
    |--------------------------------------------------------------------------
    |
    | Get your API key from https://rajaongkir.com
    | Register at https://collaborator.komerce.id for the V2 API
    |
    */
    'api_key' => env('RAJAONGKIR_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Base URL (V2 - Komerce)
    |--------------------------------------------------------------------------
    */
    'base_url' => 'https://rajaongkir.komerce.id/api/v1',

    /*
    |--------------------------------------------------------------------------
    | Origin City ID
    |--------------------------------------------------------------------------
    |
    | The city ID where your warehouse/store is located.
    | Example: 152 = Jakarta Pusat
    |
    */
    'origin_city' => env('RAJAONGKIR_ORIGIN_CITY', 152),

    /*
    |--------------------------------------------------------------------------
    | Available Couriers
    |--------------------------------------------------------------------------
    */
    'couriers' => explode(',', env('RAJAONGKIR_COURIERS', 'jne,pos,tiki')),
];

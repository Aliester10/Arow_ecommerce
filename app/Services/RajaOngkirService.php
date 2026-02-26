<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class RajaOngkirService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected int $originCity;

    public function __construct()
    {
        $this->apiKey = config('rajaongkir.api_key');
        $this->baseUrl = config('rajaongkir.base_url');
        $this->originCity = (int) config('rajaongkir.origin_city');
    }

    /**
     * Get all provinces (cached for 24 hours).
     * V2 Response: { data: [{ id, name }] }
     */
    public function getProvinces(): array
    {
        return Cache::remember('rajaongkir_provinces', 86400, function () {
            $response = Http::withHeaders([
                'key' => $this->apiKey,
            ])->get("{$this->baseUrl}/destination/province");

            if ($response->successful()) {
                return $response->json('data') ?? [];
            }

            return [];
        });
    }

    /**
     * Get cities by province ID (cached for 24 hours).
     * V2 Response: { data: [{ id, name }] }
     */
    public function getCities(int $provinceId): array
    {
        $cacheKey = 'rajaongkir_cities_' . $provinceId;

        return Cache::remember($cacheKey, 86400, function () use ($provinceId) {
            $response = Http::withHeaders([
                'key' => $this->apiKey,
            ])->get("{$this->baseUrl}/destination/city/{$provinceId}");

            if ($response->successful()) {
                return $response->json('data') ?? [];
            }

            return [];
        });
    }

    /**
     * Calculate shipping cost.
     * V2 Response: { data: [{ name, code, service, description, cost, etd }] }
     *
     * @param int    $destination  Destination city ID
     * @param int    $weight       Weight in grams
     * @param string $courier      Courier code (jne, pos, tiki)
     * @return array
     */
    public function getCost(int $destination, int $weight, string $courier): array
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey,
        ])->asForm()->post("{$this->baseUrl}/calculate/domestic-cost", [
                    'origin' => $this->originCity,
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => strtolower($courier),
                ]);

        if ($response->successful()) {
            return $response->json('data') ?? [];
        }

        return [];
    }

    /**
     * Get the origin city ID.
     */
    public function getOriginCity(): int
    {
        return $this->originCity;
    }
}

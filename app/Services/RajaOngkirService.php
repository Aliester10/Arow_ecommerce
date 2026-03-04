<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class RajaOngkirService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $originVillage;

    public function __construct()
    {
        $this->apiKey = config('rajaongkir.api_key');
        $this->baseUrl = config('rajaongkir.base_url');
        $origin = config('rajaongkir.origin_city');
        $this->originVillage = strlen((string) $origin) == 10 ? $origin : '3172051003';
    }

    public function getProvinces(): array
    {
        return Cache::remember('apicoid_provinces', 86400, function () {
            $response = Http::withHeaders([
                'x-api-co-id' => $this->apiKey,
            ])->get("{$this->baseUrl}/regional/indonesia/provinces");

            if ($response->successful() && $response->json('is_success')) {
                return $response->json('data') ?? [];
            }
            return [];
        });
    }

    public function getCities($provinceId): array
    {
        return Cache::remember('apicoid_cities_' . $provinceId, 86400, function () use ($provinceId) {
            $response = Http::withHeaders([
                'x-api-co-id' => $this->apiKey,
            ])->get("{$this->baseUrl}/regional/indonesia/regencies", ['province_code' => $provinceId]);

            if ($response->successful() && $response->json('is_success')) {
                return $response->json('data') ?? [];
            }
            return [];
        });
    }

    public function getDistricts($cityId): array
    {
        return Cache::remember('apicoid_subdistricts_' . $cityId, 86400, function () use ($cityId) {
            $response = Http::withHeaders([
                'x-api-co-id' => $this->apiKey,
            ])->get("{$this->baseUrl}/regional/indonesia/districts", ['regency_code' => $cityId]);

            if ($response->successful() && $response->json('is_success')) {
                return $response->json('data') ?? [];
            }
            return [];
        });
    }

    public function getVillages($districtId): array
    {
        return Cache::remember('apicoid_villages_' . $districtId, 86400, function () use ($districtId) {
            $response = Http::withHeaders([
                'x-api-co-id' => $this->apiKey,
            ])->get("{$this->baseUrl}/regional/indonesia/villages", ['district_code' => $districtId]);

            if ($response->successful() && $response->json('is_success')) {
                return $response->json('data') ?? [];
            }
            return [];
        });
    }

    public function getCost($destinationVillage, int $weightGrams, string $courier): array
    {
        $weightKg = ceil($weightGrams / 1000);
        if ($weightKg < 1)
            $weightKg = 1;

        $response = Http::withHeaders([
            'x-api-co-id' => $this->apiKey,
        ])->get("{$this->baseUrl}/expedition/shipping-cost", [
                    'origin_village_code' => $this->originVillage,
                    'destination_village_code' => $destinationVillage,
                    'weight' => $weightKg,
                ]);

        if ($response->successful() && $response->json('is_success')) {
            $data = $response->json('data');
            $couriers = $data['couriers'] ?? [];

            $results = [];
            foreach ($couriers as $c) {
                // Filter by chosen courier name/code
                $cCode = strtolower($c['courier_code']);
                $cName = strtolower($c['courier_name']);
                $cSearch = strtolower($courier);

                if (strpos($cCode, $cSearch) !== false || strpos($cName, $cSearch) !== false || strpos($cSearch, explode(' ', $cName)[0]) !== false) {
                    $results[] = [
                        'name' => strtoupper($c['courier_code']),
                        'code' => current(explode(' ', strtolower($c['courier_code']))),
                        'service' => $c['courier_name'],
                        'description' => $c['courier_name'],
                        'cost' => $c['price'],
                        'etd' => $c['estimation']
                    ];
                }
            }

            // Fallback if no strict match, just return all from that courier prefix (e.g JNE Cargo vs JNE)
            if (empty($results) && !empty($couriers)) {
                foreach ($couriers as $c) {
                    $results[] = [
                        'name' => strtoupper($c['courier_code']),
                        'code' => current(explode(' ', strtolower($c['courier_code']))),
                        'service' => $c['courier_name'],
                        'description' => $c['courier_name'],
                        'cost' => $c['price'],
                        'etd' => $c['estimation']
                    ];
                }
            }

            return $results;
        }

        return [];
    }

    public function getOriginVillage(): string
    {
        return $this->originVillage;
    }
}

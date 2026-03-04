<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RajaOngkirService;

class ShippingController extends Controller
{
    protected RajaOngkirService $rajaOngkir;

    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }

    /**
     * Get all provinces.
     */
    public function getProvinces()
    {
        $provinces = $this->rajaOngkir->getProvinces();

        return response()->json([
            'success' => true,
            'data' => $provinces,
        ]);
    }

    /**
     * Get cities by province ID.
     */
    public function getCities($provinceId)
    {
        $cities = $this->rajaOngkir->getCities((int) $provinceId);

        return response()->json([
            'success' => true,
            'data' => $cities,
        ]);
    }

    /**
     * Get districts by city ID.
     */
    public function getDistricts($cityId)
    {
        $districts = $this->rajaOngkir->getDistricts((int) $cityId);

        return response()->json([
            'success' => true,
            'data' => $districts,
        ]);
    }

    /**
     * Get villages by district ID.
     */
    public function getVillages($districtId)
    {
        $villages = $this->rajaOngkir->getVillages((int) $districtId);

        return response()->json([
            'success' => true,
            'data' => $villages,
        ]);
    }

    /**
     * Calculate shipping cost.
     */
    public function getCost(Request $request)
    {
        $request->validate([
            'destination' => 'required|string',
            'weight' => 'required|numeric|min:1',
            'courier' => 'required|string',
        ]);

        $results = $this->rajaOngkir->getCost(
            $request->destination,
            (int) $request->weight,
            $request->courier
        );

        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }
}

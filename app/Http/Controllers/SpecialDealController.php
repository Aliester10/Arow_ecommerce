<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpecialDeal;

class SpecialDealController extends Controller
{
    public function index()
    {
        $specialDeal = SpecialDeal::active()->with('activeProducts')->first();
        
        if (!$specialDeal) {
            return view('special-deals.empty');
        }
        
        $products = $specialDeal->activeProducts()->get();
        
        return view('special-deals.index', compact('specialDeal', 'products'));
    }
}

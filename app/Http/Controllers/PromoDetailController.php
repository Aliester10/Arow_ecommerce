<?php

namespace App\Http\Controllers;

use App\Models\PromoDetail;
use App\Models\PromoBanner;
use Illuminate\Http\Request;

class PromoDetailController extends Controller
{
    /**
     * Display the specified promo detail.
     */
    public function show($promoDetailId)
    {
        $promoDetail = PromoDetail::with(['promoBanner'])
            ->where('id_promo_detail', $promoDetailId)
            ->firstOrFail();

        // Get related promos
        $relatedPromos = PromoDetail::with(['promoBanner'])
            ->where('id_promo_detail', '!=', $promoDetailId)
            ->take(4)
            ->get();

        return view('promo.show', compact('promoDetail', 'relatedPromos'));
    }
}

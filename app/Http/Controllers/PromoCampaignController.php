<?php

namespace App\Http\Controllers;

use App\Models\PromoCampaign;

class PromoCampaignController extends Controller
{
    /**
     * Display the specified promo campaign.
     */
    public function show($slug)
    {
        $promoCampaign = PromoCampaign::where('slug', $slug)
            ->with(['products' => function ($query) {
                $query->where('status_produk', 'aktif');
            }])
            ->firstOrFail();

        return view('promo-campaigns.show', compact('promoCampaign'));
    }
}

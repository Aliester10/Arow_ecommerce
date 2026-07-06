<?php

namespace App\Http\Controllers;

use App\Models\PromoCampaign;
use App\Models\Produk;
use App\Http\Requests\StorePromoCampaignRequest;
use App\Http\Requests\UpdatePromoCampaignRequest;
use Illuminate\Support\Facades\Storage;

class AdminPromoCampaignController extends Controller
{
    /**
     * Display a listing of the promo campaigns.
     */
    public function index()
    {
        $promoCampaigns = PromoCampaign::withCount('products')->latest()->paginate(10);
        return view('admin.promo-campaigns.index', compact('promoCampaigns'));
    }

    /**
     * Show the form for creating a new promo campaign.
     */
    public function create()
    {
        $products = Produk::where('status_produk', 'aktif')->with(['subSubkategori.subkategori.kategori', 'brand'])->get();
        $otherActiveCampaigns = PromoCampaign::where('status', 'aktif')
            ->with('products:produk.id_produk')
            ->get()
            ->map(function ($campaign) {
                return [
                    'id' => $campaign->id,
                    'title' => $campaign->title,
                    'start_date' => $campaign->start_date->toISOString(),
                    'end_date' => $campaign->end_date->toISOString(),
                    'product_ids' => $campaign->products->pluck('id_produk')->toArray()
                ];
            });
        return view('admin.promo-campaigns.create', compact('products', 'otherActiveCampaigns'));
    }

    /**
     * Store a newly created promo campaign in database.
     */
    public function store(StorePromoCampaignRequest $request)
    {
        $data = $request->only(['title', 'slug', 'subtitle', 'description', 'start_date', 'end_date', 'status']);

        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $imageName = time() . '_promo_campaign.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['banner'] = $imageName;
        }

        $promoCampaign = PromoCampaign::create($data);

        $syncData = [];
        foreach ($request->selected_products as $productId) {
            $syncData[$productId] = [
                'discount_type' => $request->discount_type[$productId],
                'discount_value' => $request->discount_value[$productId],
            ];
        }

        $promoCampaign->products()->sync($syncData);

        return redirect()->route('admin.promo-campaigns.index')
            ->with('success', 'Promo Campaign berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified promo campaign.
     */
    public function edit(PromoCampaign $promoCampaign)
    {
        $promoCampaign->load('products');
        $products = Produk::where('status_produk', 'aktif')->with(['subSubkategori.subkategori.kategori', 'brand'])->get();
        
        $otherActiveCampaigns = PromoCampaign::where('status', 'aktif')
            ->where('id', '!=', $promoCampaign->id)
            ->with('products:produk.id_produk')
            ->get()
            ->map(function ($campaign) {
                return [
                    'id' => $campaign->id,
                    'title' => $campaign->title,
                    'start_date' => $campaign->start_date->toISOString(),
                    'end_date' => $campaign->end_date->toISOString(),
                    'product_ids' => $campaign->products->pluck('id_produk')->toArray()
                ];
            });
        
        // Get currently selected product IDs and their details
        $selectedProductIds = $promoCampaign->products->pluck('id_produk')->toArray();
        
        // Create an associative array of selected products with pivot details
        $selectedProductsPivot = [];
        foreach ($promoCampaign->products as $prod) {
            $selectedProductsPivot[$prod->id_produk] = [
                'discount_type' => $prod->pivot->discount_type,
                'discount_value' => $prod->pivot->discount_value,
            ];
        }

        return view('admin.promo-campaigns.edit', compact('promoCampaign', 'products', 'selectedProductIds', 'selectedProductsPivot', 'otherActiveCampaigns'));
    }

    /**
     * Update the specified promo campaign in database.
     */
    public function update(UpdatePromoCampaignRequest $request, PromoCampaign $promoCampaign)
    {
        $data = $request->only(['title', 'slug', 'subtitle', 'description', 'start_date', 'end_date', 'status']);

        if ($request->hasFile('banner')) {
            // Delete old banner
            if ($promoCampaign->banner && Storage::disk('public')->exists('images/' . $promoCampaign->banner)) {
                Storage::disk('public')->delete('images/' . $promoCampaign->banner);
            }

            $image = $request->file('banner');
            $imageName = time() . '_promo_campaign.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['banner'] = $imageName;
        }

        $promoCampaign->update($data);

        $syncData = [];
        foreach ($request->selected_products as $productId) {
            $syncData[$productId] = [
                'discount_type' => $request->discount_type[$productId],
                'discount_value' => $request->discount_value[$productId],
            ];
        }

        $promoCampaign->products()->sync($syncData);

        return redirect()->route('admin.promo-campaigns.index')
            ->with('success', 'Promo Campaign berhasil diperbarui!');
    }

    /**
     * Remove the specified promo campaign from database.
     */
    public function destroy(PromoCampaign $promoCampaign)
    {
        if ($promoCampaign->banner && Storage::disk('public')->exists('images/' . $promoCampaign->banner)) {
            Storage::disk('public')->delete('images/' . $promoCampaign->banner);
        }

        $promoCampaign->delete();

        return redirect()->route('admin.promo-campaigns.index')
            ->with('success', 'Promo Campaign berhasil dihapus!');
    }
}

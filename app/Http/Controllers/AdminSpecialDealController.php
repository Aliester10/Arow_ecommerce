<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpecialDeal;
use App\Models\Produk;

class AdminSpecialDealController extends Controller
{
    public function index()
    {
        $specialDeals = SpecialDeal::with('products')->get();
        return view('admin.special-deals.index', compact('specialDeals'));
    }

    public function create()
    {
        $products = Produk::where('status_produk', 'aktif')->get();
        return view('admin.special-deals.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'selected_products' => 'required|array',
            'selected_products.*' => 'required|exists:produk,id_produk',
            'discount_percentage' => 'required|integer|min:1|max:100',
        ]);

        $specialDeal = SpecialDeal::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'is_active' => $request->has('is_active'),
        ]);

        foreach ($request->selected_products as $productId) {
            $specialDeal->products()->attach($productId, [
                'discount_percentage' => $request->discount_percentage,
                'is_active' => true,
            ]);
        }

        return redirect()->route('admin.special-deals.index')
            ->with('success', 'Special Deal created successfully.');
    }

    public function edit(SpecialDeal $specialDeal)
    {
        $specialDeal->load('products');
        $products = Produk::where('status_produk', 'aktif')->get();
        return view('admin.special-deals.edit', compact('specialDeal', 'products'));
    }

    public function update(Request $request, SpecialDeal $specialDeal)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'selected_products' => 'required|array',
            'selected_products.*' => 'required|exists:produk,id_produk',
            'discount_percentage' => 'required|integer|min:1|max:100',
        ]);

        $specialDeal->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'is_active' => $request->has('is_active'),
        ]);

        $syncData = [];
        foreach ($request->selected_products as $productId) {
            $syncData[$productId] = [
                'discount_percentage' => $request->discount_percentage,
                'is_active' => true,
            ];
        }

        $specialDeal->products()->sync($syncData);

        return redirect()->route('admin.special-deals.index')
            ->with('success', 'Special Deal updated successfully.');
    }

    public function destroy(SpecialDeal $specialDeal)
    {
        $specialDeal->delete();
        return redirect()->route('admin.special-deals.index')
            ->with('success', 'Special Deal deleted successfully.');
    }
}

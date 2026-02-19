<?php

namespace App\Http\Controllers;

use App\Models\PromoBanner;
use App\Models\PromoDetail;
use Illuminate\Http\Request;

class AdminPromoDetailController extends Controller
{
    public function index()
    {
        $promoBanners = PromoBanner::orderBy('created_at', 'desc')->get();
        
        // If there are promo banners, redirect to the first one's details
        if ($promoBanners->count() > 0) {
            return redirect()->route('admin.promo-details.banner-index', $promoBanners->first()->id_promo_banner);
        }
        
        // If no promo banners, show empty state
        return view('admin.promo-details.no-banners');
    }

    public function bannerIndex($promoBannerId)
    {
        $promoBanner = PromoBanner::findOrFail($promoBannerId);
        $promoDetails = $promoBanner->promoDetails()->orderBy('created_at', 'desc')->get();
        
        return view('admin.promo-details.index', compact('promoBanner', 'promoDetails'));
    }

    public function create($promoBannerId)
    {
        $promoBanner = PromoBanner::findOrFail($promoBannerId);
        return view('admin.promo-details.create', compact('promoBanner'));
    }

    public function store(Request $request, $promoBannerId)
    {
        $request->validate([
            'judul_detail' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar_tambahan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $promoBanner = PromoBanner::findOrFail($promoBannerId);
        
        $data = $request->except('gambar_tambahan');
        $data['id_promo_banner'] = $promoBannerId;

        if ($request->hasFile('gambar_tambahan')) {
            $image = $request->file('gambar_tambahan');
            $imageName = time() . '_promo_detail_' . $image->getClientOriginalName();
            $image->move(public_path('storage/images'), $imageName);
            $data['gambar_tambahan'] = $imageName;
        }

        PromoDetail::create($data);

        return redirect()->route('admin.promo-details.index', $promoBannerId)
            ->with('success', 'Detail promo berhasil ditambahkan!');
    }

    public function show($promoBannerId, $promoDetailId)
    {
        $promoBanner = PromoBanner::findOrFail($promoBannerId);
        $promoDetail = PromoDetail::where('id_promo_banner', $promoBannerId)
            ->where('id_promo_detail', $promoDetailId)
            ->firstOrFail();

        return view('admin.promo-details.show', compact('promoBanner', 'promoDetail'));
    }

    public function edit($promoBannerId, $promoDetailId)
    {
        $promoBanner = PromoBanner::findOrFail($promoBannerId);
        $promoDetail = PromoDetail::where('id_promo_banner', $promoBannerId)
            ->where('id_promo_detail', $promoDetailId)
            ->firstOrFail();

        return view('admin.promo-details.edit', compact('promoBanner', 'promoDetail'));
    }

    public function update(Request $request, $promoBannerId, $promoDetailId)
    {
        $request->validate([
            'judul_detail' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar_tambahan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $promoDetail = PromoDetail::where('id_promo_banner', $promoBannerId)
            ->where('id_promo_detail', $promoDetailId)
            ->firstOrFail();

        $data = $request->except('gambar_tambahan');
        $data['aktif'] = true; // Default to active
        
        // Set removed fields to null
        $data['syarat_ketentuan'] = null;
        $data['kode_promo'] = null;
        $data['diskon_persen'] = null;
        $data['diskon_nominal'] = null;
        $data['min_pembelian'] = null;

        if ($request->hasFile('gambar_tambahan')) {
            // Delete old image
            if ($promoDetail->gambar_tambahan && file_exists(public_path('storage/images/' . $promoDetail->gambar_tambahan))) {
                unlink(public_path('storage/images/' . $promoDetail->gambar_tambahan));
            }

            // Upload new image
            $image = $request->file('gambar_tambahan');
            $imageName = time() . '_promo_detail_' . $image->getClientOriginalName();
            $image->move(public_path('storage/images'), $imageName);
            $data['gambar_tambahan'] = $imageName;
        }

        $promoDetail->update($data);

        return redirect()->route('admin.promo-details.index', $promoBannerId)
            ->with('success', 'Detail promo berhasil diperbarui!');
    }

    public function destroy($promoBannerId, $promoDetailId)
    {
        $promoDetail = PromoDetail::where('id_promo_banner', $promoBannerId)
            ->where('id_promo_detail', $promoDetailId)
            ->firstOrFail();

        // Delete image
        if ($promoDetail->gambar_tambahan && file_exists(public_path('storage/images/' . $promoDetail->gambar_tambahan))) {
            unlink(public_path('storage/images/' . $promoDetail->gambar_tambahan));
        }

        $promoDetail->delete();

        return redirect()->route('admin.promo-details.index', $promoBannerId)
            ->with('success', 'Detail promo berhasil dihapus!');
    }
}

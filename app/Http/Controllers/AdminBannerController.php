<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\SliderBanner;
use App\Models\PromoBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    // Slider Banner Methods (Display Only)
    public function sliderIndex()
    {
        $banners = SliderBanner::latest()->paginate(10);
        return view('admin.banners.slider.index', compact('banners'));
    }

    public function sliderCreate()
    {
        return view('admin.banners.slider.create');
    }

    public function sliderStore(Request $request)
    {
        $request->validate([
            'gambar_slider_banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
            'position' => 'integer|min:0',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
        ]);

        $data = $request->except('gambar_slider_banner');
        $data['active'] = $request->has('active');

        if ($request->hasFile('gambar_slider_banner')) {
            $image = $request->file('gambar_slider_banner');
            $imageName = time() . '_slider_banner.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['gambar_slider_banner'] = $imageName;
        }

        SliderBanner::create($data);

        return redirect()->route('admin.slider-banners.index')->with('success', 'Slider Banner berhasil ditambahkan!');
    }

    public function sliderEdit($id)
    {
        $banner = SliderBanner::findOrFail($id);
        return view('admin.banners.slider.edit', compact('banner'));
    }

    public function sliderUpdate(Request $request, $id)
    {
        $banner = SliderBanner::findOrFail($id);

        $request->validate([
            'gambar_slider_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'position' => 'integer|min:0',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
        ]);

        $data = $request->except('gambar_slider_banner');
        $data['active'] = $request->has('active');

        if ($request->hasFile('gambar_slider_banner')) {
            // Delete old image
            if ($banner->gambar_slider_banner && Storage::disk('public')->exists('images/' . $banner->gambar_slider_banner)) {
                Storage::disk('public')->delete('images/' . $banner->gambar_slider_banner);
            }

            $image = $request->file('gambar_slider_banner');
            $imageName = time() . '_slider_banner.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['gambar_slider_banner'] = $imageName;
        }

        $banner->update($data);

        return redirect()->route('admin.slider-banners.index')->with('success', 'Slider Banner berhasil diperbarui!');
    }

    public function sliderDestroy($id)
    {
        $banner = SliderBanner::findOrFail($id);

        if ($banner->gambar_slider_banner) {
            Storage::disk('public')->delete('images/' . $banner->gambar_slider_banner);
        }

        $banner->delete();

        return redirect()->route('admin.slider-banners.index')->with('success', 'Slider Banner berhasil dihapus!');
    }

    // Promo Banner Methods (Clickable with Links)
    public function promoIndex()
    {
        $banners = PromoBanner::latest()->paginate(10);
        return view('admin.banners.promo.index', compact('banners'));
    }

    public function promoCreate()
    {
        return view('admin.banners.promo.create');
    }

    public function promoStore(Request $request)
    {
        $request->validate([
            'gambar_promo_banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
            'id_promo_detail' => 'nullable|exists:promo_details,id_promo_detail',
        ]);

        $data = [
            'gambar_promo_banner' => '',
            'id_promo_detail' => $request->id_promo_detail,
            'active' => $request->has('active'),
        ];

        if ($request->hasFile('gambar_promo_banner')) {
            $image = $request->file('gambar_promo_banner');
            $imageName = time() . '_promo_banner.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['gambar_promo_banner'] = $imageName;
        }

        PromoBanner::create($data);

        return redirect()->route('admin.promo-banners.index')->with('success', 'Promo Banner berhasil ditambahkan!');
    }

    public function promoEdit($id)
    {
        $banner = PromoBanner::findOrFail($id);
        return view('admin.banners.promo.edit', compact('banner'));
    }

    public function promoUpdate(Request $request, $id)
    {
        $banner = PromoBanner::findOrFail($id);

        $request->validate([
            'gambar_promo_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'id_promo_detail' => 'nullable|exists:promo_details,id_promo_detail',
        ]);

        $data = [
            'id_promo_detail' => $request->id_promo_detail,
            'active' => $request->has('active'),
        ];

        if ($request->hasFile('gambar_promo_banner')) {
            // Delete old image
            if ($banner->gambar_promo_banner && Storage::disk('public')->exists('images/' . $banner->gambar_promo_banner)) {
                Storage::disk('public')->delete('images/' . $banner->gambar_promo_banner);
            }

            $image = $request->file('gambar_promo_banner');
            $imageName = time() . '_promo_banner.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['gambar_promo_banner'] = $imageName;
        }

        $banner->update($data);

        return redirect()->route('admin.promo-banners.index')->with('success', 'Promo Banner berhasil diperbarui!');
    }

    public function promoDestroy($id)
    {
        $banner = PromoBanner::findOrFail($id);

        if ($banner->gambar_promo_banner) {
            Storage::disk('public')->delete('images/' . $banner->gambar_promo_banner);
        }

        $banner->delete();

        return redirect()->route('admin.promo-banners.index')->with('success', 'Promo Banner berhasil dihapus!');
    }

    // Legacy methods for backward compatibility
    public function index()
    {
        $banners = Banner::latest()->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar_banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
            'type' => 'required|in:slider,promo_large,promo_small',
            'position' => 'integer|min:0',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'link' => 'required_if:type,promo_large,promo_small|nullable|url',
        ]);

        $data = $request->except('gambar_banner');
        $data['active'] = $request->has('active');
        
        // Ensure slider banners don't have links
        if ($request->type === 'slider') {
            $data['link'] = null;
        }

        if ($request->hasFile('gambar_banner')) {
            $image = $request->file('gambar_banner');
            $imageName = time() . '_banner.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['gambar_banner'] = $imageName;
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'gambar_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'type' => 'required|in:slider,promo_large,promo_small',
            'position' => 'integer|min:0',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'link' => 'required_if:type,promo_large,promo_small|nullable|url',
        ]);

        $data = $request->except('gambar_banner');
        $data['active'] = $request->has('active');
        
        // Ensure slider banners don't have links
        if ($request->type === 'slider') {
            $data['link'] = null;
        }

        if ($request->hasFile('gambar_banner')) {
            // Delete old image
            if ($banner->gambar_banner && Storage::disk('public')->exists('images/' . $banner->gambar_banner)) {
                Storage::disk('public')->delete('images/' . $banner->gambar_banner);
            }

            $image = $request->file('gambar_banner');
            $imageName = time() . '_banner.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['gambar_banner'] = $imageName;
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->gambar_banner) {
            Storage::disk('public')->delete('images/' . $banner->gambar_banner);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
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
        ]);

        if ($request->hasFile('gambar_banner')) {
            $image = $request->file('gambar_banner');
            $imageName = time() . '_banner.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);

            Banner::create([
                'gambar_banner' => $imageName
            ]);
        }

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
            'gambar_banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        if ($request->hasFile('gambar_banner')) {
            // Delete old image
            if ($banner->gambar_banner) {
                Storage::disk('public')->delete('images/' . $banner->gambar_banner);
            }

            $image = $request->file('gambar_banner');
            $imageName = time() . '_banner.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $image, $imageName);

            $banner->update([
                'gambar_banner' => $imageName
            ]);
        }

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

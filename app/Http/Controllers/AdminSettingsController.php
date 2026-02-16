<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::first();
        return view('admin.settings.index', compact('perusahaan'));
    }

    public function update(Request $request)
    {
        $perusahaan = Perusahaan::first();
        if (!$perusahaan) {
            $perusahaan = new Perusahaan();
        }

        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'email_perusahaan' => 'nullable|email',
            'notelp_perusahaan' => 'nullable|string',
            'alamat_perusahaan' => 'nullable|string',
            'logo_perusahaan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'member_of_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['logo_perusahaan', 'member_of_image']);

        // Handle Logo Upload
        if ($request->hasFile('logo_perusahaan')) {
            if ($perusahaan->logo_perusahaan && Storage::exists('public/images/' . $perusahaan->logo_perusahaan)) {
                Storage::delete('public/images/' . $perusahaan->logo_perusahaan);
            }
            $file = $request->file('logo_perusahaan');
            $filename = time() . '_logo.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $filename);
            $data['logo_perusahaan'] = $filename;
        }

        // Handle Member Of Image Upload
        if ($request->hasFile('member_of_image')) {
            if ($perusahaan->member_of_image && Storage::exists('public/images/' . $perusahaan->member_of_image)) {
                Storage::delete('public/images/' . $perusahaan->member_of_image);
            }
            $file = $request->file('member_of_image');
            $filename = time() . '_memberof.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $filename);
            $data['member_of_image'] = $filename;
        }

        $perusahaan->fill($data);
        $perusahaan->save();

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui!');
    }
}

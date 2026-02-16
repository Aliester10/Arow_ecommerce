<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAppearanceController extends Controller
{
    public function header()
    {
        $perusahaan = \App\Models\Perusahaan::find(1);
        return view('admin.appearance.header', compact('perusahaan'));
    }

    public function updateHeader(Request $request)
    {
        $perusahaan = \App\Models\Perusahaan::find(1);

        $data = $request->validate([
            'nama_perusahaan' => 'nullable|string',
            'notelp_perusahaan' => 'nullable|string',
            'email_perusahaan' => 'nullable|email',
            'logo_perusahaan' => 'nullable|image',
        ]);

        if ($request->hasFile('logo_perusahaan')) {
            if ($perusahaan->logo_perusahaan && \Storage::disk('public')->exists('images/' . $perusahaan->logo_perusahaan)) {
                \Storage::disk('public')->delete('images/' . $perusahaan->logo_perusahaan);
            }
            $image = $request->file('logo_perusahaan');
            $imageName = time() . '_logo.' . $image->getClientOriginalExtension();
            \Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['logo_perusahaan'] = $imageName;
        }

        $perusahaan->update($data);

        // Redirect back with a fragment to keep the user on the same tab if using tabs, or just back
        return redirect()->back()->with('success', 'Header updated successfully');
    }

    public function footer()
    {
        $perusahaan = \App\Models\Perusahaan::find(1);
        $footerLinks = \App\Models\FooterLink::all()->groupBy('column_title');
        $shippingLinks = \App\Models\FooterLink::where('column_title', 'PENGIRIMAN')->orderBy('order')->get();
        return view('admin.appearance.footer', compact('perusahaan', 'footerLinks', 'shippingLinks'));
    }

    public function updateFooter(Request $request)
    {
        $perusahaan = \App\Models\Perusahaan::find(1);

        $data = $request->validate([
            'alamat_perusahaan' => 'nullable|string',
            'footer_description' => 'nullable|string',
            'notelp_perusahaan' => 'nullable|string',
            'email_perusahaan' => 'nullable|email',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'youtube' => 'nullable|url',
            'member_of_image' => 'nullable|image',
        ]);

        if ($request->hasFile('member_of_image')) {
            if ($perusahaan->member_of_image && \Storage::disk('public')->exists('images/' . $perusahaan->member_of_image)) {
                \Storage::disk('public')->delete('images/' . $perusahaan->member_of_image);
            }
            $image = $request->file('member_of_image');
            $imageName = time() . '_memberof.' . $image->getClientOriginalExtension();
            \Storage::disk('public')->putFileAs('images', $image, $imageName);
            $data['member_of_image'] = $imageName;
        }

        // Handle Shipping Links Updates
        if ($request->has('shipping_links')) {
            foreach ($request->shipping_links as $id => $linkData) {
                $link = \App\Models\FooterLink::find($id);
                if ($link) {
                    $link->url = $linkData['url'];

                    if ($request->hasFile("shipping_links.{$id}.image")) {
                        // Delete old image
                        if ($link->image_path && \Storage::exists('public/footer_images/' . $link->image_path)) {
                            \Storage::delete('public/footer_images/' . $link->image_path);
                        }

                        $file = $request->file("shipping_links.{$id}.image");
                        $filename = time() . '_' . $link->label . '_' . $file->getClientOriginalName();
                        $file->storeAs('footer_images', $filename, 'public');
                        $link->image_path = $filename;
                        $link->type = 'image'; // Ensure type is set to image
                    }

                    $link->save();
                }
            }
        }

        $perusahaan->update($data);

        return redirect()->back()->with('success', 'Footer updated successfully');
    }
}

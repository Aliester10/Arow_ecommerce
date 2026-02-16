<?php

namespace App\Http\Controllers;

use App\Models\FooterLink;
use Illuminate\Http\Request;

class AdminFooterLinkController extends Controller
{
    public function index()
    {
        $footerLinks = FooterLink::orderBy('column_title')->orderBy('order')->get();
        return view('admin.footer_links.index', compact('footerLinks'));
    }

    public function create()
    {
        return view('admin.footer_links.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'column_title' => 'required|string|max:255',
            'type' => 'required|in:text,image',
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'order' => 'integer|min:0',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/footer_images', $filename);
            $data['image_path'] = $filename;
        }

        FooterLink::create($data);

        return redirect()->route('admin.footer_links.index')->with('success', 'Link footer berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $footerLink = FooterLink::findOrFail($id);
        return view('admin.footer_links.edit', compact('footerLink'));
    }

    public function update(Request $request, $id)
    {
        $footerLink = FooterLink::findOrFail($id);

        $request->validate([
            'column_title' => 'required|string|max:255',
            'type' => 'required|in:text,image',
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'order' => 'integer|min:0',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($footerLink->image_path && \Storage::exists('public/footer_images/' . $footerLink->image_path)) {
                \Storage::delete('public/footer_images/' . $footerLink->image_path);
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/footer_images', $filename);
            $data['image_path'] = $filename;
        }

        $footerLink->update($data);

        return redirect()->route('admin.footer_links.index')->with('success', 'Link footer berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $footerLink = FooterLink::findOrFail($id);

        if ($footerLink->image_path && \Storage::exists('public/footer_images/' . $footerLink->image_path)) {
            \Storage::delete('public/footer_images/' . $footerLink->image_path);
        }

        $footerLink->delete();

        return redirect()->route('admin.footer_links.index')->with('success', 'Link footer berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mitra;

class MitraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mitra = Mitra::orderBy('urutan')->get();
        return view('admin.mitra.index', compact('mitra'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mitra.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'nullable|string',
            'website' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer|min:0',
            'aktif' => 'boolean'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('images/mitra'), $logoName);
            $data['logo'] = 'images/mitra/' . $logoName;
        }

        $data['aktif'] = $request->has('aktif');
        Mitra::create($data);

        return redirect()->route('admin.mitra.index')
            ->with('success', 'Mitra berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mitra = Mitra::findOrFail($id);
        return view('admin.mitra.show', compact('mitra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mitra = Mitra::findOrFail($id);
        return view('admin.mitra.edit', compact('mitra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mitra = Mitra::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'nullable|string',
            'website' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer|min:0',
            'aktif' => 'boolean'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($mitra->logo && file_exists(public_path($mitra->logo))) {
                unlink(public_path($mitra->logo));
            }
            
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('images/mitra'), $logoName);
            $data['logo'] = 'images/mitra/' . $logoName;
        }

        $data['aktif'] = $request->has('aktif');
        $mitra->update($data);

        return redirect()->route('admin.mitra.index')
            ->with('success', 'Mitra berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mitra = Mitra::findOrFail($id);
        
        // Hapus logo jika ada
        if ($mitra->logo && file_exists(public_path($mitra->logo))) {
            unlink(public_path($mitra->logo));
        }
        
        $mitra->delete();

        return redirect()->route('admin.mitra.index')
            ->with('success', 'Mitra berhasil dihapus');
    }
}

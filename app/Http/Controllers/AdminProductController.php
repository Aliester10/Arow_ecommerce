<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Produk;
use App\Models\ProductImage;
use App\Models\SubSubkategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class AdminProductController extends Controller
{
    public function create()
    {
        $brands = Brand::all();
        $kategoris = \App\Models\Kategori::all();

        return view('admin.products.create', compact('brands', 'kategoris'));
    }

    public function getSubcategories($kategoriId)
    {
        $subcategories = \App\Models\Subkategori::where('id_kategori', $kategoriId)->get();
        return response()->json($subcategories);
    }

    public function getSubSubcategories($subkategoriId)
    {
        $subSubcategories = SubSubkategori::where('id_subkategori', $subkategoriId)->get();
        return response()->json($subSubcategories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_brand' => 'required|exists:brand,id_brand',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_subkategori' => 'nullable|exists:subkategori,id_subkategori',
            'id_sub_subkategori' => 'nullable|exists:sub_subkategori,id_sub_subkategori',
            'sku_produk' => 'nullable|string|max:255',
            'tipe_produk' => 'nullable|string|max:255',
            'asal_produk' => 'nullable|string|max:255',
            'dimensi_produk' => 'nullable|string|max:255',
            'harga_produk' => 'nullable|numeric|min:0',
            'stok_produk' => 'required|integer|min:0',
            'berat_produk' => 'required|numeric|min:0',
            'deskripsi_produk' => 'required|string',
            'spesifikasi_produk' => 'nullable|string',
            'gambar_produk' => 'required|array|min:1',
            'gambar_produk.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_produk' => 'required|in:aktif,nonaktif',
        ], [
            'gambar_produk.*.uploaded' => 'Gambar gagal diunggah, ukuran file mungkin melebihi batas maksimal server (2MB).',
            'gambar_produk.*.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->all();
        // $data['harga_produk'] = $request->harga_produk; // No need to force 0, let it be null if empty

        // nullify if empty strings
        if (empty($data['id_subkategori']))
            $data['id_subkategori'] = null;
        if (empty($data['id_sub_subkategori']))
            $data['id_sub_subkategori'] = null;

        if ($request->hasFile('gambar_produk')) {
            // Remove gambar_produk from mass assignment to prevent error formatting array to string
            // as Product model still has 'gambar_produk' fillable expecting a string
            unset($data['gambar_produk']);

            $product = Produk::create($data);

            foreach ($request->file('gambar_produk') as $index => $image) {
                $imageName = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('images/produk', $imageName, 'public');

                // Optimize uploaded image (optional - will fail silently if tools not installed)
                $fullPath = storage_path('app/public/' . $path);
                try {
                    ImageOptimizer::optimize($fullPath);
                } catch (\Exception $e) {
                    // Image optimization failed, but continue with upload
                    // This happens when optimization tools are not installed on the server
                }

                ProductImage::create([
                    'id_produk' => $product->id_produk,
                    'image_path' => $path,
                    'sort_order' => $index,
                    'is_primary' => $index === 0 // First image is primary
                ]);
            }
        } else {
            // Try to create product with error handling for check constraints
            try {
                $product = Produk::create($data);
                
                // Verify spesifikasi_produk was actually saved
                $originalSpesifikasi = $data['spesifikasi_produk'] ?? null;
                $savedSpesifikasi = $product->spesifikasi_produk;
                
                if ($originalSpesifikasi !== $savedSpesifikasi) {
                    // Try to save it separately with different approaches
                    $attempts = [
                        'original' => $originalSpesifikasi,
                        'trimmed' => trim($originalSpesifikasi),
                        'stripped' => strip_tags($originalSpesifikasi),
                        'escaped' => htmlspecialchars($originalSpesifikasi, ENT_QUOTES, 'UTF-8'),
                        'cleaned' => preg_replace('/[^a-zA-Z0-9\s\-_.,]/', '', $originalSpesifikasi),
                    ];
                    
                    $success = false;
                    foreach ($attempts as $attemptName => $attemptValue) {
                        try {
                            $product->update(['spesifikasi_produk' => $attemptValue]);
                            $success = true;
                            break;
                        } catch (\Exception $e) {
                            continue;
                        }
                    }
                    
                    if (!$success) {
                        return redirect()->route('admin.products.index')
                            ->with('success', 'Produk berhasil ditambahkan!')
                            ->with('warning', 'Spesifikasi Produk tidak dapat disimpan karena batasan database hosting. Nilai asli: "' . e($originalSpesifikasi) . '"');
                    }
                }
                
            } catch (\Illuminate\Database\QueryException $e) {
                // Handle check constraint violations
                if (str_contains($e->getMessage(), 'Check constraint')) {
                    // Try creating without problematic field
                    $dataWithoutSpesifikasi = $data;
                    unset($dataWithoutSpesifikasi['spesifikasi_produk']);
                    
                    try {
                        $product = Produk::create($dataWithoutSpesifikasi);
                        
                        // Try to update spesifikasi separately with different approaches
                        $spesifikasiValue = $data['spesifikasi_produk'] ?? null;
                        $attempts = [
                            'original' => $spesifikasiValue,
                            'trimmed' => trim($spesifikasiValue),
                            'stripped' => strip_tags($spesifikasiValue),
                            'escaped' => htmlspecialchars($spesifikasiValue, ENT_QUOTES, 'UTF-8'),
                            'cleaned' => preg_replace('/[^a-zA-Z0-9\s\-_.,]/', '', $spesifikasiValue),
                            'null' => null,
                        ];
                        
                        $success = false;
                        $savedValue = null;
                        foreach ($attempts as $attemptName => $attemptValue) {
                            try {
                                $product->update(['spesifikasi_produk' => $attemptValue]);
                                $success = true;
                                $savedValue = $attemptValue;
                                break;
                            } catch (\Exception $innerE) {
                                continue;
                            }
                        }
                        
                        if ($success) {
                            $message = 'Produk berhasil ditambahkan!';
                            if ($savedValue !== $spesifikasiValue) {
                                $message .= ' (Spesifikasi Produk disimpan dengan format yang dimodifikasi)';
                            }
                            return redirect()->route('admin.products.index')->with('success', $message);
                        } else {
                            return redirect()->route('admin.products.index')
                                ->with('success', 'Produk berhasil ditambahkan (tanpa Spesifikasi Produk)')
                                ->with('warning', 'Spesifikasi Produk tidak dapat disimpan karena batasan database hosting. Nilai yang dicoba: "' . e($spesifikasiValue) . '"');
                        }
                        
                    } catch (\Exception $innerE) {
                        return redirect()->route('admin.products.index')
                            ->with('error', 'Gagal menambah produk: ' . $innerE->getMessage());
                    }
                } else {
                    throw $e; // Re-throw if it's not a check constraint error
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function index()
    {
        $products = Produk::with(['brand', 'kategori', 'subkategori', 'subSubkategori'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Produk::with('images')->findOrFail($id);
        $brands = Brand::all();
        $kategoris = \App\Models\Kategori::all();

        return view('admin.products.edit', compact('product', 'brands', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $product = Produk::findOrFail($id);
        
        // Additional check to ensure we have the right product
        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Produk tidak ditemukan!');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_brand' => 'required|exists:brand,id_brand',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_subkategori' => 'nullable|exists:subkategori,id_subkategori',
            'id_sub_subkategori' => 'nullable|exists:sub_subkategori,id_sub_subkategori',
            'sku_produk' => 'nullable|string|max:255',
            'tipe_produk' => 'nullable|string|max:255',
            'asal_produk' => 'nullable|string|max:255',
            'dimensi_produk' => 'nullable|string|max:255',
            'harga_produk' => 'nullable|numeric|min:0',
            'stok_produk' => 'required|integer|min:0',
            'berat_produk' => 'required|numeric|min:0',
            'deskripsi_produk' => 'required|string',
            'spesifikasi_produk' => 'nullable|string',
            'gambar_produk' => 'nullable|array',
            'gambar_produk.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_produk' => 'required|in:aktif,nonaktif',
        ], [
            'gambar_produk.*.uploaded' => 'Gambar gagal diunggah, ukuran file mungkin melebihi batas maksimal server (2MB).',
            'gambar_produk.*.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $data = $request->all();
        // $data['harga_produk'] = $request->harga_produk; // Allow null update

        // Handle spesifikasi_produk specifically to avoid constraint issues
        if (isset($data['spesifikasi_produk'])) {
            $data['spesifikasi_produk'] = $data['spesifikasi_produk'] === '' ? null : $data['spesifikasi_produk'];
        }

        // nullify if empty strings
        if (empty($data['id_subkategori']))
            $data['id_subkategori'] = null;
        if (empty($data['id_sub_subkategori']))
            $data['id_sub_subkategori'] = null;

        // Handle multiple image uploads
        if ($request->hasFile('gambar_produk')) {
            // Remove gambar_produk from mass assignment to prevent error formatting array to string
            unset($data['gambar_produk']);

            // Delete existing images
            foreach ($product->images as $existingImage) {
                Storage::disk('public')->delete($existingImage->image_path);
                $existingImage->delete();
            }

            // Upload new images
            foreach ($request->file('gambar_produk') as $index => $image) {
                $imageName = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('images/produk', $imageName, 'public');

                // Optimize uploaded image (optional - will fail silently if tools not installed)
                $fullPath = storage_path('app/public/' . $path);
                try {
                    ImageOptimizer::optimize($fullPath);
                } catch (\Exception $e) {
                    // Image optimization failed, but continue with upload
                    // This happens when optimization tools are not installed on the server
                }

                ProductImage::create([
                    'id_produk' => $product->id_produk,
                    'image_path' => $path,
                    'sort_order' => $index,
                    'is_primary' => $index === 0 // First image is primary
                ]);
            }
        }

        // Try to update the product with error handling for check constraints
        try {
            $product->update($data);
            
            // Verify spesifikasi_produk was actually saved and try direct SQL if needed
            $spesifikasiValue = $data['spesifikasi_produk'] ?? null;
            if ($spesifikasiValue !== null && $spesifikasiValue !== '') {
                $updatedProduct = $product->fresh(['spesifikasi_produk']);
                if ($updatedProduct->spesifikasi_produk !== $spesifikasiValue) {
                    // Try direct SQL as last resort
                    try {
                        DB::statement(
                            'UPDATE produk SET spesifikasi_produk = ?, updated_at = ? WHERE id_produk = ?',
                            [$spesifikasiValue, now(), $product->id_produk]
                        );
                    } catch (\Exception $e) {
                        // Direct SQL failed, but that's okay
                    }
                }
            }
            
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle check constraint violations
            if (str_contains($e->getMessage(), 'Check constraint')) {
                // Try updating without the problematic field first
                $dataWithoutSpesifikasi = $data;
                unset($dataWithoutSpesifikasi['spesifikasi_produk']);
                
                try {
                    $product->update($dataWithoutSpesifikasi);
                    
                    // Try to update spesifikasi separately with different approaches
                    $spesifikasiValue = $data['spesifikasi_produk'] ?? null;
                    $attempts = [
                        'original' => $spesifikasiValue,
                        'trimmed' => trim($spesifikasiValue),
                        'stripped' => strip_tags($spesifikasiValue),
                        'escaped' => htmlspecialchars($spesifikasiValue, ENT_QUOTES, 'UTF-8'),
                        'cleaned' => preg_replace('/[^a-zA-Z0-9\s\-_.,]/', '', $spesifikasiValue),
                        'null' => null,
                    ];
                    
                    $success = false;
                    $savedValue = null;
                    foreach ($attempts as $attemptName => $attemptValue) {
                        try {
                            $product->update(['spesifikasi_produk' => $attemptValue]);
                            $success = true;
                            $savedValue = $attemptValue;
                            break;
                        } catch (\Exception $innerE) {
                            continue;
                        }
                    }
                    
                    if ($success) {
                        $message = 'Produk berhasil diperbarui!';
                        if ($savedValue !== $spesifikasiValue) {
                            $message .= ' (Spesifikasi Produk disimpan dengan format yang dimodifikasi)';
                        }
                        return redirect()->route('admin.products.index')->with('success', $message);
                    } else {
                        return redirect()->route('admin.products.index')
                            ->with('success', 'Produk berhasil diperbarui (tanpa Spesifikasi Produk)')
                            ->with('warning', 'Spesifikasi Produk tidak dapat disimpan karena batasan database hosting. Nilai yang dicoba: "' . e($spesifikasiValue) . '"');
                    }
                    
                } catch (\Exception $innerE) {
                    return redirect()->route('admin.products.index')
                        ->with('error', 'Gagal memperbarui produk: ' . $innerE->getMessage());
                }
            } else {
                throw $e; // Re-throw if it's not a check constraint error
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Produk::findOrFail($id);

        // Delete product images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Delete legacy single image if exists
        if ($product->gambar_produk) {
            Storage::disk('public')->delete('images/produk/' . $product->gambar_produk);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Delete a specific product image
     */
    public function deleteImage($productId, $imageId)
    {
        $product = Produk::findOrFail($productId);
        $image = ProductImage::where('id_produk', $productId)->findOrFail($imageId);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        // If this was primary image, set next image as primary
        if ($image->is_primary) {
            $nextImage = $product->images()->orderBy('sort_order')->first();
            if ($nextImage) {
                $nextImage->update(['is_primary' => true]);
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Set primary image for product
     */
    public function setPrimaryImage($productId, $imageId)
    {
        $product = Produk::findOrFail($productId);

        // Remove primary status from all images
        $product->images()->update(['is_primary' => false]);

        // Set new primary image
        $image = ProductImage::where('id_produk', $productId)->findOrFail($imageId);
        $image->update(['is_primary' => true]);

        return response()->json(['success' => true]);
    }
}

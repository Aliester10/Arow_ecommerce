<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        // Try different approach
        $categories = Category::all();
        foreach ($categories as $category) {
            $category->sub_categories_count = SubCategory::where('id_kategori', $category->id_kategori)->count();
        }

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'icon_kategori' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('icon_kategori')) {
            $image = $request->file('icon_kategori');
            $imageName = Str::slug($request->nama_kategori) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/images/kategori'), $imageName);
            $data['icon_kategori'] = 'kategori/' . $imageName;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'icon_kategori' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('icon_kategori')) {
            // Delete old image if exists
            if ($category->icon_kategori && file_exists(public_path('storage/images/' . $category->icon_kategori))) {
                unlink(public_path('storage/images/' . $category->icon_kategori));
            }

            $image = $request->file('icon_kategori');
            $imageName = Str::slug($request->nama_kategori) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/images/kategori'), $imageName);
            $data['icon_kategori'] = 'kategori/' . $imageName;
        } else {
            // Keep existing image if no new image uploaded
            unset($data['icon_kategori']);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();

            // Delete image if exists, only after successful DB deletion
            if ($category->icon_kategori && file_exists(public_path('storage/images/' . $category->icon_kategori))) {
                unlink(public_path('storage/images/' . $category->icon_kategori));
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('admin.categories.index')
                    ->with('error', 'Tidak dapat menghapus Kategori ini karena masih memiliki Sub Kategori atau Kategori ini masih digunakan.');
            }

            return redirect()->route('admin.categories.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}

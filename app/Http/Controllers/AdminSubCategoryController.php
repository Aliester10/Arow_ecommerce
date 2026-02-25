<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class AdminSubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category', 'subSubCategories')->get();
        return view('admin.sub-categories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.sub-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_subkategori' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori'
        ]);

        SubCategory::create($request->all());

        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Sub Kategori berhasil ditambahkan');
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::all();
        return view('admin.sub-categories.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'nama_subkategori' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori'
        ]);

        $subCategory->update($request->all());

        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Sub Kategori berhasil diperbarui');
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();

        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Sub Kategori berhasil dihapus');
    }
}

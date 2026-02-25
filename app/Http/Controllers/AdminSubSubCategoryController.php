<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;

class AdminSubSubCategoryController extends Controller
{
    public function index()
    {
        $subSubCategories = SubSubCategory::with('subCategory.category')->get();
        return view('admin.sub-sub-categories.index', compact('subSubCategories'));
    }

    public function create()
    {
        $subCategories = SubCategory::with('category')->get();
        return view('admin.sub-sub-categories.create', compact('subCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sub_subkategori' => 'required|string|max:255',
            'id_subkategori' => 'required|exists:subkategori,id_subkategori'
        ]);

        SubSubCategory::create($request->all());

        return redirect()->route('admin.sub-sub-categories.index')
            ->with('success', 'Sub Sub Kategori berhasil ditambahkan');
    }

    public function edit(SubSubCategory $subSubCategory)
    {
        $subCategories = SubCategory::with('category')->get();
        return view('admin.sub-sub-categories.edit', compact('subSubCategory', 'subCategories'));
    }

    public function update(Request $request, SubSubCategory $subSubCategory)
    {
        $request->validate([
            'nama_sub_subkategori' => 'required|string|max:255',
            'id_subkategori' => 'required|exists:subkategori,id_subkategori'
        ]);

        $subSubCategory->update($request->all());

        return redirect()->route('admin.sub-sub-categories.index')
            ->with('success', 'Sub Sub Kategori berhasil diperbarui');
    }

    public function destroy(SubSubCategory $subSubCategory)
    {
        $subSubCategory->delete();

        return redirect()->route('admin.sub-sub-categories.index')
            ->with('success', 'Sub Sub Kategori berhasil dihapus');
    }
}

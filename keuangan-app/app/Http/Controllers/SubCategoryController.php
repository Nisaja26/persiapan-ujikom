<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->get(); // ikut ambil kategori
        return view('sub_categories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::all(); // ambil semua kategori untuk dropdown
        return view('sub_categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sub_categories',
            'category_id' => 'required|exists:categories,id', // validasi kategori
        ]);

        SubCategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('sub-categories.index')->with('success', 'Jenis Transaksi created successfully.');
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::all();
        return view('sub_categories.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sub_categories,name,' . $subCategory->id,
            'category_id' => 'required|exists:categories,id',
        ]);

        $subCategory->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('sub-categories.index')->with('success', 'Jenis Transaksi updated successfully.');
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();
        return redirect()->route('sub-categories.index')->with('success', 'Jenis Transaksi deleted successfully.');
    }

    public function getByCategory($category_id)
{
    $subCategories = SubCategory::where('category_id', $category_id)->get();
    return response()->json($subCategories);
}
}

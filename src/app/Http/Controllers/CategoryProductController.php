<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-category-product', ['only' => ['store']]);
        $this->middleware('permission:read-category-product', ['only' => ['index']]);
        $this->middleware('permission:edit-category-product', ['only' => ['update']]);
        $this->middleware('permission:delete-category-product', ['only' => ['destroy']]);
    }

    public function index()
    {
        $metadata = [
            'title' => 'Kategori Produk',
            'description' => 'Data Management',
            'submenu' => 'category-product',
        ];
        $categoryProducts = CategoryProduct::all();
        return view('pages.data-management.category-product.index', compact('categoryProducts', 'metadata'));
    }
    
    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        CategoryProduct::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', "Data $request->name berhasil ditambahkan");
    }
    
    public function show(CategoryProduct $categoryProduct)
    {
        abort(404);
    }
    
    public function edit(CategoryProduct $categoryProduct)
    {
        $metadata = [
            'title' => 'Edit Kategori Produk',
            'description' => 'Data Management',
            'submenu' => 'category-product',
        ];

        if(auth()->user()->can('edit-category-product')) {
            return view('pages.data-management.category-product.edit', compact('categoryProduct', 'metadata'));
        } else {
            abort(403, "You don't have permission");
        }
    }
    
    public function update(Request $request, CategoryProduct $categoryProduct)
    {
        if(auth()->user()->can('edit-category-product')) {
        $categoryProduct->update($request->all());
        return redirect()->route('category-product.index')->with('success', "Data $categoryProduct->name berhasil diperbaharui!");
        } else {
            abort(403, "You don't have permission");
        }
    }
    
    public function destroy(CategoryProduct $categoryProduct)
    {
        $categoryProduct->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}

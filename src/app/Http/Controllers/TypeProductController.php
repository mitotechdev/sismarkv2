<?php

namespace App\Http\Controllers;

use App\Models\TypeProduct;
use Illuminate\Http\Request;

class TypeProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-type-product', ['only' => ['store']]);
        $this->middleware('permission:read-type-product', ['only' => ['index']]);
        $this->middleware('permission:edit-type-product', ['only' => ['update']]);    
        $this->middleware('permission:delete-type-product', ['only' => ['destroy']]);
    }

    public function index()
    {
        $metadata = [
            'title' => 'Jenis Produk',
            'description' => 'Data Management',
            'submenu' => 'type-product',
        ];
        $typeProducts = TypeProduct::all();
        return view('pages.data-management.type-product.index', [
            'metadata' => $metadata,
            'typeProducts' => $typeProducts
        ]);
    }
    
    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        TypeProduct::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }
    
    public function show(TypeProduct $typeProduct)
    {
        abort(404);
    }
    
    public function edit(TypeProduct $typeProduct)
    {
        $metadata = [
            'title' => 'Edit Jenis Produk',
            'description' => 'Data Management',
            'submenu' => 'type-product',
        ];
        return view('pages.data-management.type-product.edit', compact('typeProduct', 'metadata'));
    }
    
    public function update(Request $request, TypeProduct $typeProduct)
    {
        $typeProduct->update($request->all());
        return redirect()->route('type-product.index')->with('success', 'Data berhasil diperbaharui!');
    }
    
    public function destroy(TypeProduct $typeProduct)
    {
        $typeProduct->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}

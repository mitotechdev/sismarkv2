<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Builder $builder)
    {
        $products = Product::latest()->get();
        if( request()->ajax() ) {
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('aksi', function($data) {
                    return view('components.action-product', compact('data'));
                })
                ->rawColumns(['aksi'])
                ->make();
        }
       
        return view('pages.product.product');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:products',
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->with('error', "$request->code")->withInput();
        } else {
            Product::create([
                'code' => $request->code,
                'name' => $request->name,
                'packaging' => $request->packaging,
                'unit' => $request->unit,
                'category' => $request->category,
            ]);
            return redirect()->back()->with('success', "$request->code");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('pages.product.product-detail', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('pages.product.product-edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return redirect()->route('product.index')->with('success', "Data produk $product->code berhasil diperbaharui!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', "Data $product->code berhasil dihapus dari databases!");
    }
}

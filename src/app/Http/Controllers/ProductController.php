<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\TypeProduct;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-product', ['only' => ['store']]);
        $this->middleware('permission:read-product', ['only' => ['index', 'show']]);
        $this->middleware('permission:edit-product', ['only' => ['update']]);
        $this->middleware('permission:delete-product', ['only' => ['destroy']]);
    }

    public function index()
    {
        $metadata = [
            'title' => 'Produk',
            'description' => 'Data Master',
            'submenu' => 'product',
        ];

        $products = Product::latest()->get();
        $categoryProducts = CategoryProduct::all();
        $typeProducts = TypeProduct::all();
        if( request()->ajax() ) {
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('category', function($data) {
                    return $data->category_product->name;
                })
                ->addColumn('aksi', function($data) {
                    return view('components.action-product', compact('data'));
                })
                ->rawColumns(['aksi'])
                ->make();
        }
       
        return view('pages.product.product', [
            'categoryProducts' => $categoryProducts,
            'typeProducts' => $typeProducts,
            'metadata' => $metadata,
        ]);
    }
    
    public function create()
    {
        abort(404);
    }
    
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
                'name' => $request->name_product,
                'packaging' => $request->packaging,
                'unit' => $request->unit,
                'type_product_id' => $request->type_of_product,
                'category_product_id' => $request->category,
            ]);
            return redirect()->back()->with('success', "$request->code");
        }
    }
    
    public function show(Product $product)
    {
        $metadata = [
            'title' => 'Produk',
            'description' => 'Data Master',
            'submenu' => 'product',
        ];

        $categoryProducts = CategoryProduct::all();
        $typeProducts = TypeProduct::all();
        return view('pages.product.product-detail', compact('product', 'categoryProducts', 'typeProducts', 'metadata'));
    }
    
    public function edit(Product $product)
    {
        $metadata = [
            'title' => 'Edit Produk',
            'description' => 'Data Master',
            'submenu' => 'product',
        ];
        $categoryProducts = CategoryProduct::all();
        $typeProducts = TypeProduct::all();
        return view('pages.product.product-edit', compact('product', 'categoryProducts', 'typeProducts', 'metadata'));
    }
    
    public function update(Request $request, Product $product)
    {
        $product->update([
            'code'=> $request->code,
            'name' => $request->name_product,
            'packaging' => $request->packaging,
            'unit' => $request->unit,
            'type_product_id' => $request->type_of_product,
            'category_product_id' => $request->category,
        ]);
        return redirect()->route('product.index')->with('success', "Data produk $product->code berhasil diperbaharui!");
    }
    
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', "Data $product->code berhasil dihapus dari databases!");
    }
}

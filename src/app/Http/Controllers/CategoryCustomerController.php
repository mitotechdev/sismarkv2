<?php

namespace App\Http\Controllers;

use App\Models\CategoryCustomer;
use Illuminate\Http\Request;

class CategoryCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-segment-customer', ['only' => ['store']]);
        $this->middleware('permission:read-segment-customer', ['only' => ['index']]);
        $this->middleware('permission:edit-segment-customer', ['only' => ['update']]);
        $this->middleware('permission:delete-segment-customer', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $metadata = [
            'title' => 'Segmen Customer',
            'description' => 'Data Management',
            'submenu' => 'segment-customer',
        ];

        $categoryCustomers = CategoryCustomer::latest()->get();
        return view('pages.category-customer.category-customer', compact('categoryCustomers', 'metadata'));
    }
    
    public function create()
    {
        abort(404);
    }
    
    public function store(Request $request)
    {
        CategoryCustomer::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', "Data $request->name berhasil ditambahkan!");
    }
    
    public function show(CategoryCustomer $categoryCustomer)
    {
        abort(404);
    }
    
    public function edit(CategoryCustomer $categoryCustomer)
    {
        abort(404);
    }
    
    public function update(Request $request, CategoryCustomer $categoryCustomer)
    {
        $categoryCustomer->update([
            'name' => $request->name
        ]);
        return redirect()->back()->with("success", "Data berhasil diperbaharui!");
    }
    
    public function destroy(CategoryCustomer $categoryCustomer)
    {
        $categoryCustomer->delete();
        return redirect()->back()->with("success", "Data berhasil $categoryCustomer->name dihapus!");
    }
}

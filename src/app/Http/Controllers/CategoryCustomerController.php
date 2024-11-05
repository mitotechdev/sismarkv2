<?php

namespace App\Http\Controllers;

use App\Models\CategoryCustomer;
use Illuminate\Http\Request;

class CategoryCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoryCustomers = CategoryCustomer::latest()->get();
        return view('pages.category-customer.category-customer', compact('categoryCustomers'));
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
    public function store(Request $request)
    {
        CategoryCustomer::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', "Data $request->name berhasil ditambahkan!");
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryCustomer $categoryCustomer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryCustomer $categoryCustomer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryCustomer $categoryCustomer)
    {
        $categoryCustomer->update([
            'name' => $request->name
        ]);
        return redirect()->back()->with("success", "Data berhasil diperbaharui!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryCustomer $categoryCustomer)
    {
        $categoryCustomer->delete();
        return redirect()->back()->with("success", "Data berhasil $categoryCustomer->name dihapus!");
    }
}

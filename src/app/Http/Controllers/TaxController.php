<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ( request()->ajax() ) {
            return DataTables::of(Tax::query()->latest())
            ->addIndexColumn()
            ->addColumn('aksi', function($tax) {
                return view('components.action-tax', compact('tax'));
            })
            ->rawColumns(['aksi'])
            ->make();
        }

        return view('pages.tax');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'tax' => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->with('error', 'Pastikan data anda sudah benar!');
        } else {
            Tax::create([
                'name' => $request->name,
                'tax' => $request->tax,
            ]);
            return redirect()->back()->with('success', "$request->name");
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tax $tax)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tax $tax)
    {
        $tax->update($request->all());
        return redirect()->back()->with('updated', "$request->name");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tax $tax)
    {
        $tempName = $tax->name;
        $tax->delete();
        return redirect()->back()->with('deleted', "$tempName");
    }
}

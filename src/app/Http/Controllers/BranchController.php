<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::select('*')->latest();
        if (request()->ajax()) {
            return DataTables::of($branches)
                    ->addIndexColumn()
                    ->addColumn('aksi', function($branch) {
                        return view('components.action-branch', compact('branch'));
                    })
                    ->rawColumns(['aksi'])
                    ->toJson();
        }
        return view('pages.branch');
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
            'code' => 'required|unique:branches',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', "$request->code");
        } else {
            Branch::create([
                'code' => $request->code,
                'name' => $request->name,
                'npwp' => $request->npwp,
                'phone' => $request->phone,
                'address' => $request->address,
                'pic' => $request->pic,
            ]);
            return redirect()->back()->with('success', "$request->code");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $branch->update([
            'code' => $request->code,
            'name' => $request->name,
            'npwp' => $request->npwp,
            'phone' => $request->phone,
            'address' => $request->address,
            'pic' => $request->pic
        ]);

        return redirect()->back()->with('updated', "$request->code");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $nameTemp = $branch->code;
        $branch->delete();
        return redirect()->back()->with('deleted', "$nameTemp");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-branch', ['only' => ['store']]);
        $this->middleware('permission:read-branch', ['only' => ['index']]);
        $this->middleware('permission:edit-branch', ['only' => ['update']]);
        $this->middleware('permission:delete-branch', ['only' => ['destroy']]);
    }

    public function index()
    {
        $metadata = [
            'title' => 'Branches',
            'description' => 'Data Master',
            'submenu' => 'branches',
        ];
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
        return view('pages.branch', compact('metadata'));
    }
    
    public function create()
    {
        abort(404);
    }

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
            return redirect()->back()->with('success', "Produk $request->code berhasil ditambahkan!");
        }
    }
    
    public function show(Branch $branch)
    {
        abort(404);
    }

    public function edit(Branch $branch)
    {
        abort(404);
    }

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

        return redirect()->back()->with('success', "$request->code berhasil diperbaharui!");
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->back()->with('success', "$branch->code berhasil dihapus!");
    }
}

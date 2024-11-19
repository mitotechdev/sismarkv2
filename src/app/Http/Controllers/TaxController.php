<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-tax', ['only' => ['store']]);
        $this->middleware('permission:read-tax', ['only' => ['index']]);
        $this->middleware('permission:edit-tax', ['only' => ['update']]);
        $this->middleware('permission:delete-tax', ['only' => ['destroy']]);
    }

    public function index()
    {
        $metadata = [
            'title' => 'Pajax',
            'description' => 'Data Management',
            'submenu' => 'taxes',
        ];

        if ( request()->ajax() ) {
            return DataTables::of(Tax::query()->latest())
            ->addIndexColumn()
            ->addColumn('aksi', function($tax) {
                return view('components.action-tax', compact('tax'));
            })
            ->rawColumns(['aksi'])
            ->make();
        }

        return view('pages.tax', compact('metadata'));
    }
    
    public function create()
    {
        abort(404);
    }
    
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
    
    public function show(Tax $tax)
    {
        abort(404);
    }
    
    public function edit(Tax $tax)
    {
        abort(404);
    }
    
    public function update(Request $request, Tax $tax)
    {
        $tax->update($request->all());
        return redirect()->back()->with('success', "$request->name berhasil ditambahkan!");
    }
    
    public function destroy(Tax $tax)
    {
        $tax->delete();
        return redirect()->back()->with('success', "$tax->name berhasil dihapus!");
    }
}

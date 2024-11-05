<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Product::select('*')->where('type_product', 'Jasa');
        if (request()->ajax()) {
            return DataTables::of($services)
                ->addIndexColumn()
                ->addColumn('aksi', function($service) {
                    return view('components.action-service', compact('service'));
                })
                ->rawColumns(['aksi'])
                ->make();
        }
        return view('pages.service');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:products',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->With('error', "$request->code");
        } else {
            Product::create([
                'code' => $request->code,
                'name' => $request->name,
                'packaging' => '-',
                'unit' => $request->unit,
                'category' => $request->category,
                'type_product' => 'Jasa',
                'desc' => $request->desc,
            ]);
            return redirect()->back()->with('success', $request->code);
        }
    }


    public function edit($id)
    {
        $service = Product::find($id);
        return view('pages.service-edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Product::find($id);
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'name' => 'required',
            'unit' => 'required',
            'desc' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Data tidak dapat diperbaharui!')->withInput();
        } else {
            $service->update([
                'code' => $request->code,
                'name' => $request->name,
                'unit' => $request->unit,
                'desc' => $request->desc,
            ]);
            return redirect()->route('service.index')->with('updated', $request->code);
        }
    }

    public function destroy($id)
    {
        $service = Product::find($id);
        $tmpCode = $service->code;
        $service->delete();
        return redirect()->back()->with('deleted', "$tmpCode");
    }
}

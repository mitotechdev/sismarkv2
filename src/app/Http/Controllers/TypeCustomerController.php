<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\TypeCustomer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TypeCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            return DataTables::of(TypeCustomer::latest()->get())
                ->addIndexColumn()
                ->addColumn('aksi', function($typeCustomer) {
                    $random = Str::random(5);
                    return view('components.action-type-customer', compact('typeCustomer', 'random'));
                })
                ->rawColumns(['aksi'])
                ->make();
        }
        return view('pages.type-customer');
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
            'tag_front_end' => 'required',
            'tag_status' => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->with('error', 'Permintaan Anda tidak dapat dieksekusi, perhatikan data yang di input telah benar');
        } else {
            TypeCustomer::create([
                'name' => $request->name,
                'tag_front_end' => $request->tag_front_end,
                'tag_status' => $request->tag_status
            ]);
            return redirect()->back()->with('success', "$request->name");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeCustomer $typeCustomer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeCustomer $typeCustomer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeCustomer $typeCustomer)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'tag_front_end' => 'required',
            'tag_status' => 'required'
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->with('error', 'Permintaan anda tidak dapat diproses, perhatian data input Anda.');
        } else {
            $typeCustomer->update([
                'name' => $request->name,
                'tag_front_end' => $request->tag_front_end,
                'tag_status' => $request->tag_status
            ]);
            return redirect()->back()->with('success', "$request->name");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeCustomer $typeCustomer)
    {
        return redirect()->back()->with('warning', 'Anda tidak dapat melakukan penghapusan data ini. Sistem dapat malfungsi jika anda melanjutkan eksekusi ini, yang menggangu relasi database.');
    }
}

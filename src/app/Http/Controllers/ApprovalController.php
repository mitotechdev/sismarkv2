<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( request()->ajax() ) {
            return DataTables::of(Approval::query()->latest())
            ->addIndexColumn()
            ->addColumn('aksi', function($approval) {
                return view('components.action-approval', compact('approval'));
            })
            ->rawColumns(['aksi'])
            ->make();
        }

        return view('pages.approval');
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
        Approval::create([
            'name' => $request->name,
            'tag_front_end' => $request->tag_front_end,
            'tag_status' => $request->tag_status,
        ]);

        return redirect()->back()->with('success', "$request->name");
    }

    /**
     * Display the specified resource.
     */
    public function show(Approval $approval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Approval $approval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Approval $approval)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'tag_front_end' => 'required',
            'tag_status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Pastikan inputan tidak kosong!');
        } else {
            $approval->update([
                'name' => $request->name,
                'tag_front_end' => $request->tag_front_end,
                'tag_status' => $request->tag_status,
            ]);
            return redirect()->back()->with('updated', "$request->name");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Approval $approval)
    {
        return redirect()->back()->with('denied', 'Anda tidak dapat melakukan penghapusan data ini. Sistem dapat malfungsi jika anda melanjutkan eksekusi ini, yang menggangu relasi database.');
    }
}

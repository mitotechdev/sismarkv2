<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Models\Branch;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function branch()
    {
        $data = Branch::onlyTrashed()->get();
        if (request()->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($branch) {
                    return view('components.action-trash-branch', compact('branch'));
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }
        return view('trashes.branch');
    }

    public function recoveryBranch($id)
    {
        $branch = Branch::onlyTrashed()->where('id', $id)->first();
        $branch->restore();
        return redirect()->back()->with('restore', "$branch->name");
    }

    public function deletePermanentlyBranch($id)
    {
        $branch = Branch::onlyTrashed()->where('id', $id)->first();
        $branch->forceDelete();
        return redirect()->back()->with('deleted', "$branch->name");
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use App\Models\Workplan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MarketProgress;
use App\Models\ProgressWorkplan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class WorkplanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-realisasi-kerja', ['only' => ['store']]);
        $this->middleware('permission:read-realisasi-kerja', ['only' => ['index']]);
        $this->middleware('permission:edit-realisasi-kerja', ['only' => ['editWorkplan','update']]);
        $this->middleware('permission:delete-realisasi-kerja', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $metadata = [
            'title' => 'Realisasi Kerja',
            'description' => 'Marketing',
            'submenu' => 'realisasi-kerja',
        ];

        $customers = Customer::where('branch_id', Auth::user()->branch_id)->latest()->get();
        if(auth()->user()->can('admin-view')) {
            $workplans = Workplan::where('branch_id', Auth::user()->branch_id)->latest()->get();
        } else {
            $workplans = Workplan::where('branch_id', Auth::user()->branch_id)->where('sales_id', Auth::user()->id)->latest()->get();
        }


        if ( request()->ajax() ) {
            return DataTables::of($workplans)
                    ->addIndexColumn()
                    ->addColumn('sales', function($data) {
                        return $data->sales->name;
                    })
                    ->addColumn('name_customer', function($data) {
                        return $data->customer->name;
                    })
                    ->addColumn('segmen', function($data) {
                        return $data->customer->category_customer->name;
                    })
                    ->addColumn('progress', function($data) {
                        return view('components.badge.workplan.badge-market-progress', compact('data'));
                    })
                    ->addColumn('status', function($data) {
                        return view('components.badge.workplan.badge-status', compact('data'));
                    })
                    ->addColumn('aksi', function($data) {
                        $random = Str::random(4);
                        return view('components.action-workplan', compact('random', 'data'));
                    })
                    ->rawColumns(['aksi'])
                    ->make();
        }
        return view('pages.workplan.index', compact('customers', 'metadata'));
    }
    
    public function create()
    {
        abort(404);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_customer' => 'required',
            'category_customer' => 'required'
        ], [
            'name_customer.required' => 'Masukan customer terlebih dahulu',
            'category_customer.required' => 'Masukan kategori customer terlebih dahulu'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $now = Carbon::now();
            $year = $now->format('y');
            $month = $now->format('m');

            $latestWorkplan = Workplan::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->orderByDesc('code_workplan')
                ->first();

            if ($latestWorkplan) {
                $latestCode = substr($latestWorkplan->code_workplan, -3);
                $newCode = str_pad((int)$latestCode + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $newCode = '001';
            }

            $fullCode = "P-{$year}{$month}{$newCode}";

            $workplan = Workplan::create([
                'code_workplan' => $fullCode,
                'sales_id' => Auth::user()->id,
                'customer_id' => $request->name_customer,
                'category_customer_id' => $request->category_customer,
                'branch_id' => Auth::user()->branch_id
            ]);

            return redirect()->route('workplan.edit', $workplan->id)->with('success', 'Data workplan baru berhasil di input!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }
    
    public function show(Workplan $workplan)
    {
        $metadata = [
            'title' => 'Data Realisasi Kerja',
            'description' => 'Marketing',
            'submenu' => 'realisasi-kerja',
        ];

        if ((auth()->user()->can('read-realisasi-kerja') && auth()->user()->id == $workplan->sales_id) || auth()->user()->can('admin-view')) {
            $progressWorkplans = ProgressWorkplan::with('workplan')->where('workplan_id', $workplan->id)->latest()->get();
            return view('pages.workplan.show', compact('workplan', 'progressWorkplans', 'metadata'));
        } else {
            abort(403);
        }
    }
    
    public function edit(Workplan $workplan) //This for create progress in menu Workplan
    {
        $metadata = [
            'title' => 'Progress Kerja',
            'description' => 'Marketing',
            'submenu' => 'realisasi-kerja',
        ];
        if(auth()->user()->can('admin-view')) {
            $marketProgress = MarketProgress::get();
            $progressWorkplans = ProgressWorkplan::with('workplan')->where('workplan_id', $workplan->id)->latest()->get();
        } else {
            if(auth()->user()->id != $workplan->sales_id) {
                abort(404, "Not Found");
            } else {
                $marketProgress = MarketProgress::get();
                $progressWorkplans = ProgressWorkplan::with('workplan')
                                     ->where('workplan_id', $workplan->id)
                                     ->where('user_id', auth()->user()->id)
                                     ->latest()
                                     ->get();
            }
        }
        
        return view('pages.workplan.progress.progress', compact('workplan', 'marketProgress', 'progressWorkplans', 'metadata'));
    }
    
    public function update(Request $request, Workplan $workplan)
    {
        $validateData = Validator::make($request->all(), [
            'name_customer' => 'required',
            'category_customer' => 'required'
        ]);

        if ($validateData->fails()) {
            return redirect()->back()->withErrors($validateData)->withInput();
        }

        $workplan->update([
            'customer_id' => $request->name_customer,
            'category_customer_id' => $request->category_customer,
        ]);
        
        return redirect()->route('workplan.index')->with("success", "Data workplan berhasil diperbaharui!");
    }
    
    public function destroy(Workplan $workplan)
    {
        $workplan->delete();
        return redirect()->back()->with("success", "Data berhasil di hapus dari database!");
    }

    public function editWorkplan(Workplan $workplan)
    {
        $metadata = [
            'title' => 'Edit Realisasi Kerja',
            'description' => 'Marketing',
            'submenu' => 'realisasi-kerja',
        ];

        if(auth()->user()->id != $workplan->sales_id && !auth()->user()->hasRole('Super Admin')) {
            abort(403);
        } else {
            $sales = User::with('branch')->where('branch_id', 1)->get();
            $customers = Customer::latest()->get();
            return view('pages.workplan.edit', compact('workplan', 'sales', 'customers', 'metadata'));
        }
    }
}

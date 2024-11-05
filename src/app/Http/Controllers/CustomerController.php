<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Models\CategoryCustomer;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->where('branch_id', Auth::user()->branch_id)->get();
        $categories = CategoryCustomer::latest()->get();
        $customers = Customer::with('branch', 'user', 'type_customer', 'category_customer')
                    ->where('branch_id', Auth::user()->branch_id)
                    ->latest()->get();
        if(request()->ajax()) {
            return DataTables::of($customers)
                ->addIndexColumn()
                ->addColumn('sales_name', function($customer) {
                    if($customer->user != null) {
                        return $customer->user->name;
                    } else {
                        return 'N/A';
                    }
                })
                ->addColumn('category_customer', function($data) {
                    return $data->category_customer->name;
                })
                ->addColumn('status', function($data) {
                    return [
                        'name_status' => $data->type_customer->name,
                        'tag_front_end' => $data->type_customer->tag_front_end,
                    ];
                })
                ->addColumn('aksi', function($data) {
                    return view('components.action-customer', compact('data'));
                })
                ->rawColumns(['aksi'])
                ->make();
        }
        return view('pages.customer.customer', compact('users', 'categories'));
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
            'name_customer' => 'required|unique:customers,name',
            'category_customer' => 'required',
            'npwp' => 'required',
            'name_owner' => 'required',
            'address' => 'required',
            'city' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'desc_technical' => 'required',
            'desc_clasification' => 'required',
            'pic_sales' => 'required',
        ],
        [
            'name_customer.unique' => "Nama $request->name_customer telah terdaftar.",
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->with('error', 'Permintaan tidak dapat diproses, perhatian inputan Anda.')->withInput();
        } else {
            Customer::create([
                'name' => $request->name_customer,
                'category_customer_id' => $request->category_customer,
                'npwp' => $request->npwp,
                'address' => $request->address,
                'city' => $request->city,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'owner' => $request->name_owner,
                'branch_id' => Auth::user()->branch_id,
                'user_id' => $request->pic_sales,
                'desc_clasification' => $request->desc_clasification,
                'desc_technical' => $request->desc_technical,
            ]);
            return redirect()->back()->with("success", "$request->name");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('pages.customer.customer-detail', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $categories = CategoryCustomer::latest()->get();
        $branches = Branch::latest()->get();
        $users = User::latest()->get();
        return view('pages.customer.customer-edit', compact('customer', 'branches', 'users', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $customer->update([
            'name' => $request->name_customer,
            'category_customer_id' => $request->category_customer,
            'npwp' => $request->npwp,
            'address' => $request->address,
            'city' => $request->city,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'owner' => $request->name_owner,
            'branch_id' => $request->branch_system,
            'user_id' => $request->pic_sales,
            'desc_clasification' => $request->desc_clasification,
            'desc_technical' => $request->desc_technical,
        ]);
        return redirect()->route('customer.index')->with('success', "Data $customer->name berhasil diperbaharui!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}

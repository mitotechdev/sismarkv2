<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tax;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SalesOrder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\UniqueNumber;
use App\Models\SalesOrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SalesOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-purchase-order', ['only' => ['store']]);
        $this->middleware('permission:read-purchase-order', ['only' => ['index', 'show']]);
        $this->middleware('permission:edit-purchase-order', ['only' => ['update']]);
        $this->middleware('permission:delete-purchase-order', ['only' => ['destroy']]);
    }

    public function index()
    {
        $metadata = [
            'title' => 'Purchase Order',
            'description' => 'Sales',
            'submenu' => 'purchase-order',
        ];

        $countPerCategorySegmen = SalesOrder::where('branch_id', Auth::user()->branch_id)
                ->select('segmen_id', DB::raw('count(*) as total_po'))
                ->groupBy('segmen_id')
                ->with('segmen')
                ->get();

        $customers = Customer::latest()->where('branch_id', Auth::user()->branch_id)->get();
        $salesOrders = SalesOrder::with('customer', 'approval')
                       ->where('branch_id', Auth::user()->branch_id)
                       ->latest()
                       ->get();
        $users = User::latest()->where('branch_id', Auth::user()->branch_id)->where('status', 0)->get();
        $taxes = Tax::latest()->get();
        if ( request()->ajax() ) {
            return DataTables::of($salesOrders)
                ->addIndexColumn()
                ->addColumn('tanggal_order', function($data) {
                    return $data->order_date->format('d/m/Y');
                })
                ->addColumn('sales', function($data) {
                    return $data->sales->name;
                })
                ->addColumn('konsumen', function($data) {
                    return $data->customer->name;
                })
                ->addColumn('segmen', function($data) {
                    return $data->segmen->name;
                })
                ->addColumn('status', function($data) {
                    return $data;
                })
                ->addColumn('aksi', function($data) use ($customers, $users, $taxes) {
                    $random = Str::random(5);
                    return view('components.action-sales-order', compact('data', 'random', 'customers', 'users', 'taxes'));
                })
                ->rawColumns(['aksi'])
                ->make();
        }
        return view('pages.sales-order.sales-order', compact('customers', 'taxes', 'users', 'countPerCategorySegmen', 'metadata'));
    }

    
    public function create()
    {
        abort(404);
    }
    
    public function store(Request $request)
    {
        $numberSalesOrder = UniqueNumber::generateNumberSalesOrder();
        $validator = Validator::make($request->all(), [
            'sales' => 'required',
            'no_sales_order' => 'required|unique:sales_orders',
            'name_customer' => 'required',
            'tax_rate' => 'required',
            'order_date' => 'required',
        ],
        [
            'no_sales_order.unique' => "Nomor po customer $request->no_sales_order telah terdaftar sebelumnya",
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $salesOrder =SalesOrder::create([
                'code' => $numberSalesOrder,
                'no_sales_order' => $request->no_sales_order,
                'customer_id' => $request->name_customer,
                'segmen_id' => $request->segmen,
                'tax_id' => $request->tax_rate,
                'branch_id' => Auth::user()->branch_id,
                'approval_id' => '1',
                'order_date' => $request->order_date,
                'created_by' => Auth::user()->name,
                'sales_id' => $request->sales,
                'status_payment' => 0,
            ]);

            return redirect()->route('sales.order.item', $salesOrder->id)->with('success', " Berhasil input! Silahkan input item sales order $numberSalesOrder ");
        }
    }
    
    public function show(SalesOrder $salesOrder)
    {
        $metadata = [
            'title' => 'Detail Purchase Order',
            'description' => 'Sales',
            'submenu' => 'purchase-order',
        ];
        return view('pages.sales-order.sales-order-detail', compact('salesOrder', 'metadata'));
    }
    
    public function edit(SalesOrder $salesOrder)
    {
        $metadata = [
            'title' => 'Edit Purchase Order',
            'description' => 'Sales',
            'submenu' => 'purchase-order',
        ];

        if($salesOrder->approval_id != 1) {
            abort(403, 'Unauthorized action');
        } else {
            if(auth()->user()->can('edit-purchase-order') && $salesOrder->branch_id == Auth::user()->branch_id) {
                $customers = Customer::latest()->where('branch_id', Auth::user()->branch_id)->get();
                $users = User::latest()->where('branch_id', Auth::user()->branch_id)->where('status', 0)->get();
                $taxes = Tax::latest()->get();
                return view('pages.sales-order.sales-order-edit', compact('salesOrder', 'users', 'taxes', 'customers', 'metadata'));
            } else {
                abort(403, "You don't have permission");
            }
        }
    }
    
    public function update(Request $request, SalesOrder $salesOrder)
    {
        $validator = Validator::make($request->all(), [
            'sales' => 'required',
            'name_customer' => 'required',
            'tax_rate' => 'required',
            'order_date' => 'required',
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $salesOrder->update([
                'no_sales_order' => $request->no_sales_order,
                'customer_id' => $request->name_customer,
                'tax_id' => $request->tax_rate,
                'approval_id' => '1',
                'order_date' => $request->order_date,
                'sales_id' => $request->sales,
                'status_payment' => 0,
            ]);

            return redirect()->route('sales-order.index')->with('success', "Data sales order $salesOrder->no_sales_order berhasil diperbaharui!");
        }
    }
    
    public function destroy(SalesOrder $salesOrder)
    {
        $salesOrder->delete();
        return redirect()->route('sales-order.index')->with('success', "Data sales order $salesOrder->no_sales_order berhasil dihapus!");
    }


    public function item(SalesOrder $salesOrder)
    {
        $metadata = [
            'title' => 'Item Purchase Order',
            'description' => 'Sales',
            'submenu' => 'purchase-order',
        ];

        if($salesOrder->approval_id != 1) {
            abort(403, 'Unauthorized action');
        } else {
            if(auth()->user()->can('read-purchase-order') && $salesOrder->branch_id == Auth::user()->branch_id) {
                $products = Product::latest()->get();
                $salesOrderItems = SalesOrderItem::with('sales_order')
                                    ->where('sales_order_id', $salesOrder->id)
                                    ->get();
                return view('pages.sales-order-item', compact('salesOrderItems', 'salesOrder', 'products', 'metadata'));
            }
            else {
                abort(403, "You don't have permission");
            }
        }
    }

    public function storeItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'total_amount' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            SalesOrderItem::create($request->all());
            return redirect()->back()->with('success', 'Item berhasil ditambahkan!');
        }
    }

    public function updateItem(Request $request, SalesOrderItem $salesOrderItem)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'discount' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Permintaan anda tidak dapat di proses!');
        } else {
            $salesOrderItem->update([
                'product_id' => $request->product_id,
                'qty' => $request->qty,
                'price' => $request->price,
                'discount' => $request->discount,
                'total_amount' => $request->total_amount,
            ]);
            return redirect()->back()->with('updated', 'Data berhasil diperbaharui');
        }
    }

    public function destroyItem(SalesOrderItem $salesOrderItem)
    {
        $salesOrderItem->delete();
        return redirect()->back()->with('deleted', 'Data berhasil dihapus!');
    }

    public function submitItem(SalesOrder $salesOrder)
    {
        $salesOrder->update(['approval_id' => 2]);
        return redirect()->route('sales-order.index')->with('submitted', "$salesOrder->no_sales_order");
    }

    public function approveSalesOrder(SalesOrder $salesOrder)
    {
        $salesOrder->update([
            'approval_id' => '3',
        ]);

        // update once type customer when order
        $customer = Customer::find($salesOrder->customer_id);
        if($customer->type_customer_id != 3) {
            $customer->update([ 
                'type_customer_id' => 3
            ]);
        }

        return redirect()->back()->with('success', "PO $salesOrder->code telah di Approved!");
    }

    public function api($id)
    {
        $data = SalesOrder::with('sales_order_items','tax', 'recap_invoice')->find($id);
        return response()->json($data);
    }
}

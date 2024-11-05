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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countPerCategorySegmen = SalesOrder::where('branch_id', Auth::user()->branch_id)
                ->select('segmen_id', DB::raw('count(*) as total_po'))
                ->groupBy('segmen_id')
                ->with('segmen')
                ->get();

        $customers = Customer::latest()->where('branch_id', Auth::user()->branch_id)->get();
        $salesOrders = SalesOrder::with('customer', 'approval')->where('branch_id', Auth::user()->branch_id)->latest()->get();
        $users = User::latest()->where('branch_id', Auth::user()->branch_id)->get();
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
                ->addColumn('top', function($data) {
                    $top_range = $data->order_date->diffInDays(Carbon::parse($data->term_of_payment));;
                    return $top_range .' Hari';
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
        return view('pages.sales-order.sales-order', compact('customers', 'taxes', 'users', 'countPerCategorySegmen'));
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
        $numberSalesOrder = UniqueNumber::generateNumberSalesOrder();
        $validator = Validator::make($request->all(), [
            'sales' => 'required',
            'no_sales_order' => 'required|unique:sales_orders',
            'name_customer' => 'required',
            'tax_rate' => 'required',
            'order_date' => 'required',
            'top' => 'required',
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
                'term_of_payment' => $request->top,
                'created_by' => Auth::user()->name,
                'sales_id' => $request->sales,
                'status_payment' => 0,
            ]);

            return redirect()->route('sales.order.item', $salesOrder->id)->with('success', " Berhasil input! Silahkan input item sales order $numberSalesOrder ");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesOrder $salesOrder)
    {
        return view('pages.sales-order.sales-order-detail', compact('salesOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesOrder $salesOrder)
    {
        $customers = Customer::latest()->where('branch_id', Auth::user()->branch_id)->get();
        $users = User::latest()->where('branch_id', Auth::user()->branch_id)->get();
        $taxes = Tax::latest()->get();
        return view('pages.sales-order.sales-order-edit', compact('salesOrder', 'users', 'taxes', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesOrder $salesOrder)
    {
        $validator = Validator::make($request->all(), [
            'sales' => 'required',
            'name_customer' => 'required',
            'tax_rate' => 'required',
            'order_date' => 'required',
            'top' => 'required',
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
                'term_of_payment' => $request->top,
                'sales_id' => $request->sales,
                'status_payment' => 0,
            ]);

            return redirect()->route('sales-order.index')->with('success', "Data sales order $salesOrder->no_sales_order berhasil diperbaharui!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesOrder $salesOrder)
    {
        $salesOrder->delete();
        return redirect()->route('sales-order.index')->with('success', "Data sales order $salesOrder->no_sales_order berhasil dihapus!");
    }


    public function item(SalesOrder $salesOrder)
    {
        $products = Product::latest()->get();

        $salesOrderItems = SalesOrderItem::with('sales_order')
                            ->where('sales_order_id', $salesOrder->id)
                            ->get();
        if ($salesOrderItems->isNotEmpty() && $salesOrder->approval_id == 1) {
            $openRequest = true;
        } else {
            $openRequest = false;
        }
        return view('pages.sales-order-item', compact('salesOrderItems', 'salesOrder', 'products', 'openRequest'));
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

    public function outstanding()
    {
        $outstandings = SalesOrder::with('customer', 'sales_order_items')->where('paid', false)->where('approval_id', 3)->latest()->get();
        if (request()->ajax()) {
            return DataTables::of($outstandings)
                ->addIndexColumn()
                ->addColumn('total', function($data) {
                    $total = $data->sales_order_items->sum('total_amount');
                    $ppn = $total * $data->tax->tax;
                    $grandTotal = $total + $ppn;
                    return 'Rp '. number_format($grandTotal, 2, ',', '.');
                })
                ->addColumn('konsumen', function($data) {
                    return $data->customer->name;
                })
                ->addColumn('status', function($data) {
                    if($data->paid == false) {
                        return 'Belum lunas';
                    }
                })
                ->addColumn('aksi', function($data) {
                    return 'xxxx;';
                })
                ->rawColumns(['aksi'])
                ->make();
        }
        return view('pages.outstanding');
    }
}

<?php

use App\Models\CategoryCustomer;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesOrder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SalesOrderItem;
use App\Models\Workplan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('product/{product}', function (Product $product) {
    return response()->json($product);
})->name('api.product.show');


Route::get('testing', function() {
    $salesOrders = SalesOrder::with('customer', 'approval', 'tax', 'recap_invoice')
                                   ->where('branch_id', 1)
                                   ->where('approval_id', 3)
                                   ->latest()
                                   ->get();

    // Hitung Total PO keseluruhan items
    foreach ($$salesOrders as $row) {
        $totalPo = 0;
        foreach ($row->sales_order_items as $item) {
            $subTotal = $item->qty * $item->price;
            $totalPo += $subTotal;
        }
        $ppn = $totalPo * $row->tax->tax;
        $grandTotal = $totalPo + $ppn;

        $totalOutstanding = 0;

        $totalInvoicePaid = 0;
        $totalInvoiceUnpaid = 0;

        foreach ($data->recap_invoice as $item) {
            if ($item->date_payment != null) {
                $totalInvoicePaid += $item->total_payment;
            } else {
                $totalInvoiceUnpaid += $item->total_payment;
            }
        }
        

        if ($grandTotal >= $totalInvoicePaid) {
            if ($totalInvoiceUnpaid >= $totalInvoicePaid) {
                $totalOutstanding = $totalInvoiceUnpaid - $totalInvoicePaid;

            }
        }
    }
});



Route::get('customer/{id}', function($id) {
    $customer = Customer::with('category_customer', 'type_customer')->find($id);
    return response()->json($customer);
})->name('api.customer.show');














// TESTING
// Mendapatkan data Purchase Order yang telah terbit invoice
Route::get('testing', function() {
    $salesOrderItems = SalesOrderItem::with('product', 'sales_order.branch')->latest()
        ->get();

    return response()->json($salesOrderItems);
});


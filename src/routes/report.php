<?php

use App\Models\User;
use App\Models\Workplan;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('sales-order', function() {
    $data = SalesOrder::select('segmen_id', DB::raw('count(*) as total_po'))
            ->groupBy('segmen_id')
            ->with('segmen')
            ->get();
    return response()->json($data);
})->name('report.sales.order');


Route::get('sales-order-item', function() {
    $salesOrders = SalesOrder::with('customer', 'sales_order_items', 'sales')->get();
    $sum = $salesOrders->filter(fn($query) => $query->customer->category_customer_id == 3)->count();
    return response()->json($sum);
});

Route::get('workplan', function() {
    $workplans = Workplan::select('sales_id', 'category_customer_id', DB::raw('COUNT(*) as total_count'))
                            ->groupBy('sales_id','category_customer_id')
                            ->get();
    return response()->json($workplans);
});

Route::get('progress', function(Request $request) {
    $dateDataMin = $request->dateMin;
    if(request()->ajax()) {return response()->json(['data' => $dateDataMin]);}
})->name('report.progress.api');

Route::get('sales-order', function() {
    $purchaseOrder = SalesOrder::where('approval_id', '3')->with('sales_order_items')->get();
    return response()->json($purchaseOrder);
});

Route::get('sales-api', function() {
    $data = SalesOrder::with('sales_order_items', 'segmen')->get();

    return response()->json($data);
});


Route::get('sales-order/{id}', function($id) {
    $data = SalesOrder::with('sales_order_items.product', 'customer.category_customer', 'tax', 'recap_invoice')
        ->find($id);
    return response()->json($data);
});




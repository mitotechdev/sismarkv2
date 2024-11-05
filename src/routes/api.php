<?php

use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesOrder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SalesOrderItem;
use App\Models\Workplan;
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


Route::get('testing/{id}', function($id) {
    // $data = SalesOrder::with('sales_order_items', 'customer')->find($id);

    // $totalAmount = 0;

    // foreach ($data->sales_order_items as $item) {
    //     $totalAmount += $item->qty * floatval($item->price);

    // }

    // return response()->json([
    //     'data' => $data, 
    //     'total_amount' => $totalAmount,
    // ]);
    $data = SalesOrder::with('sales_order_items')->latest()->get();

// Menambahkan order_date ke setiap item di sales_order_items
foreach ($data as $order) {
    foreach ($order->sales_order_items as $item) {
        $item->order_date = $order->order_date; // Mengambil order_date dari induknya
    }
}

// Menghitung jumlah sales_order_items di bulan yang sama
$countSameMonth = 0;

foreach ($data as $order) {
    $orderMonth = $order->order_date->format('m'); // Mengambil bulan dari order_date
    $orderYear = $order->order_date->format('Y'); // Mengambil tahun dari order_date

    $countSameMonth += $order->sales_order_items->filter(function ($item) use ($orderMonth, $orderYear) {
        return $item->order_date->format('m') === $orderMonth && $item->order_date->format('Y') === $orderYear;
    })->count();
}

return response()->json([
    'data' => $data,
    'count_same_month' => $countSameMonth,
]);

});



Route::get('customer/{id}', function($id) {
    $customer = Customer::with('category_customer', 'type_customer')->find($id);
    return response()->json($customer);
})->name('api.customer.show');



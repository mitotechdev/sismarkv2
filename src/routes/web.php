<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryCustomerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogOutController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProgressWorkplanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\TypeCustomerController;
use App\Http\Controllers\MarketProgressController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WorkplanController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::fallback(function () { return abort(404);});
Route::get     ('login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post    ('authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

Route::middleware(['auth'])->group(function () {
    Route::get     ('/', DashboardController::class)->name('home');
    Route::post    ('logout', LogOutController::class)->name('logout');
    Route::get     ('user-show', [UsersController::class, 'preview'])->name('preview');
    Route::resource('user', UsersController::class);
    Route::resource('approval', ApprovalController::class);
    Route::resource('tax', TaxController::class);
    Route::resource('type-customer', TypeCustomerController::class);
    Route::resource('market-progress', MarketProgressController::class);
    Route::resource('category-customer', CategoryCustomerController::class); 
    Route::resource('customer', CustomerController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('product', ProductController::class);
    Route::get     ('service', [ServiceController::class, 'index'])->name('service.index');
    Route::post    ('service', [ServiceController::class, 'store'])->name('service.store');
    Route::get     ('service/{id}/edit', [ServiceController::class, 'edit'])->name('service.edit');
    Route::put     ('service/{id}/item', [ServiceController::class, 'update'])->name('service.update');
    Route::delete  ('service/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');

    Route::resource('workplan', WorkplanController::class);

    Route::post    ('workplan/progress', [ProgressWorkplanController::class, 'store'])->name('progress.store');
    Route::delete  ('workplan/progress/{progressWorkplan}', [ProgressWorkplanController::class, 'destroy'])->name('progress.destroy');
    Route::get     ('workplan/progress/{progressWorkplan}/edit', [ProgressWorkplanController::class, 'edit'])->name('progress.edit');
    Route::put     ('workplan/progress/{progressWorkplan}', [ProgressWorkplanController::class, 'update'])->name('progress.update');


    Route::get     ('workplan/{workplan}/status', [WorkplanController::class, 'manageStatusWorkplan'])->name('workplan.status');
    Route::put     ('workplan/{workplan}/status', [WorkplanController::class, 'updateStatusWorkplan'])->name('workplan.update.status');
    Route::get     ('workplan/{workplan}/data', [WorkplanController::class, 'editWorkplan'])->name('workplan.edit.data');
    //Transaction
    Route::resource('sales-order', SalesOrderController::class);
    Route::get     ('sales-order/{salesOrder}/item', [SalesOrderController::class, 'item'])->name('sales.order.item');
    Route::put     ('sales-order/{salesOrderItem}/item', [SalesOrderController::class, 'updateItem'])->name('sales.order.item.update');
    Route::delete  ('sales-order/{salesOrderItem}/item', [SalesOrderController::class, 'destroyItem'])->name('sales.order.item.destroy');
    Route::put     ('sales-order/{salesOrder}/submit', [SalesOrderController::class, 'submitItem'])->name('sales.order.item.submit');
    Route::put     ('sales-order/{salesOrder}/approved', [SalesOrderController::class, 'approveSalesOrder'])->name('sales.order.approve');

    Route::post    ('sales-order/item', [SalesOrderController::class, 'storeItem'])->name('sales.order.store.item');
    Route::get     ('outstanding', [SalesOrderController::class, 'outstanding'])->name('sales.order.outstanding');
    //Trash Data
    Route::get     ('trash-branch', [TrashController::class, 'branch'])->name('trash.branch');
    Route::put     ('trash-branch/{id}', [TrashController::class, 'recoveryBranch'])->name('recovery.branch');
    Route::delete  ('trash-branch/{id}', [TrashController::class, 'deletePermanentlyBranch'])->name('delete.permanently.branch');



    // Report 
    Route::get     ('report/sales', [ReportController::class, 'reportSales'])->name('report.sales');
    Route::get     ('report/{user}/detail', [ReportController::class, 'reportSalesDetail'])->name('report.sales.detail');
    Route::get     ('report/purchase-order', [ReportController::class, 'reportSalesOrder'])->name('report.purchase.order');
    Route::get     ('report/recap-progress', [ReportController::class, 'reportRecapProgress'])->name('report.progress');

    // Download
    Route::get     ('download/progress', [PrintController::class, 'recapProgress'])->name('print.recap.progress');
    Route::get     ('download/progress/search', [PrintController::class, 'searchDataProgress'])->name('search.recap.progress');
    Route::post    ('export/progress', [PrintController::class, 'exportProgress'])->name('export.progress');
    Route::get     ('download/purchase-order', [PrintController::class, 'purchaseOrder'])->name('download.purchase.order');
    Route::get     ('export/purchase-order', [PrintController::class, 'exportPurchaseOrder'])->name('export.purchase.order');
});

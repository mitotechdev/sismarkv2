<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\LogOutController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WorkplanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\TypeCustomerController;
use App\Http\Controllers\MarketProgressController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CategoryCustomerController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProgressWorkplanController;
use App\Http\Controllers\RecapController;
use App\Http\Controllers\RecapInvoiceController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TypeProductController;

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

Route::middleware(['auth', 'role_or_permission_custom'])->group(function () {
    Route::get     ('/', DashboardController::class)->name('home');
    Route::post    ('logout', LogOutController::class)->name('logout');
    // Data Management
    Route::resource('category-product', CategoryProductController::class);
    Route::resource('type-product', TypeProductController::class);
    Route::resource('category-customer', CategoryCustomerController::class);
    Route::resource('tax', TaxController::class);
    Route::resource('market-progress', MarketProgressController::class);
    // Data Master
    Route::resource('product', ProductController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('customer', CustomerController::class);
    // Marketing
    Route::resource('workplan', WorkplanController::class);
    Route::get     ('workplan/{workplan}/data', [WorkplanController::class, 'editWorkplan'])->name('workplan.edit.data');
    Route::resource('progress-workplan', ProgressWorkplanController::class);
    // Sales
    Route::resource('sales-order', SalesOrderController::class);
    Route::get     ('sales-order/{salesOrder}/item', [SalesOrderController::class, 'item'])->name('sales.order.item');
    Route::post    ('sales-order/item', [SalesOrderController::class, 'storeItem'])->name('sales.order.store.item');
    Route::put     ('sales-order/{salesOrderItem}/item', [SalesOrderController::class, 'updateItem'])->name('sales.order.item.update');
    Route::delete  ('sales-order/{salesOrderItem}/item', [SalesOrderController::class, 'destroyItem'])->name('sales.order.item.destroy');
    Route::put     ('sales-order/{salesOrder}/submit', [SalesOrderController::class, 'submitItem'])->name('sales.order.item.submit');
    Route::put     ('sales-order/{salesOrder}/approved', [SalesOrderController::class, 'approveSalesOrder'])->name('sales.order.approve');
    Route::resource('recap-invoice', RecapInvoiceController::class);
    // Reports
    Route::get     ('report/recap-progress', [ReportController::class, 'reportRecapProgress'])->name('report.progress');
    Route::get     ('report/purchase-order', [ReportController::class, 'reportPurchaseOrder'])->name('report.purchase.order');
    Route::get     ('report/list-purchase-order', [ReportController::class, 'reportSalesOrder'])->name('report.list.purchase.order');
    // Download
    Route::get     ('download/progress', [PrintController::class, 'recapProgress'])->name('print.recap.progress');
    Route::post    ('export/progress', [PrintController::class, 'exportProgress'])->name('export.progress');
    Route::get     ('download/purchase-order', [PrintController::class, 'purchaseOrder'])->name('download.purchase.order');
    Route::get     ('export/purchase-order', [PrintController::class, 'exportPurchaseOrder'])->name('export.purchase.order');
    Route::get     ('download/payment', [PrintController::class, 'payment'])->name('download.payment');
    Route::post    ('export/payment/pdf', [PrintController::class, 'exportPaymentPdf'])->name('export.payment.pdf');
    Route::post    ('export/payment/excel', [PrintController::class, 'exportPaymentExcel'])->name('export.payment.excel');
    // Users
    Route::resource('user', UsersController::class);
    Route::resource('roles', RolesController::class);
    Route::put     ('role-give-permission/{role}', [RolesController::class, 'givePermission'])->name('role.give.permission');
    // Pengaturan
    Route::get     ('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put     ('pengaturan/{user}', [PengaturanController::class, 'update'])->name('pengaturan.update');
    //Trash Data
    Route::get     ('trash-branch', [TrashController::class, 'branch'])->name('trash.branch');
    Route::put     ('trash-branch/{id}', [TrashController::class, 'recoveryBranch'])->name('recovery.branch');
    Route::delete  ('trash-branch/{id}', [TrashController::class, 'deletePermanentlyBranch'])->name('delete.permanently.branch');    
    // Reponse Data
    Route::get('sales-order-data/{id}', [SalesOrderController::class, 'api'])->name('sales.order.api');
});




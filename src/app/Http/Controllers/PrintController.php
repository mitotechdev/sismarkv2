<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Workplan;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use App\Exports\SalesOrderReportExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ProgressWorkplan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PrintController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pull-report-progress', ['only' => ['recapProgress', 'exportProgress']]);
        $this->middleware('permission:pull-report-po', ['only' => ['purchaseOrder', 'exportPurchaseOrder']]);
        $this->middleware('permission:pull-report-payment', ['only' => ['payment', 'exportPaymentPdf', 'exportPaymentExcel']]);
    }

    public function recapProgress(Request $request)
    {
        $metadata = [
            'title' => 'Download Progress',
            'description' => 'Download',
            'submenu' => 'download-progress',
        ];

        $salesData = $request->has('sales') ? $request->sales : null;
        $dateMin = $request->has('dateMin') ? $request->dateMin : null;
        $dateMax = $request->has('dateMax') ? $request->dateMax : null;

        $sales = User::where('branch_id', Auth::user()->branch_id)->where('status', 0)->get();
        
        if( $salesData != null && $dateMin != null && $dateMax != null ) {
            $dataSearch = ProgressWorkplan::where('user_id', $salesData)
                ->whereBetween('date_progress', [$dateMin, $dateMax])
                ->with('workplan', 'market_progress', 'sales')
                ->latest()
                ->get();
        } elseif ( $salesData == null && $dateMin != null && $dateMax != null ) {
            $dataSearch = ProgressWorkplan::whereBetween('date_progress', [$request->dateMin, $request->dateMax])
                ->with('workplan', 'market_progress')
                ->latest()
                ->get();
        } else {
            $dataSearch = null;
        }
        return view('download.recap-progress', compact('sales', 'dataSearch', 'metadata'));
    }

    public function exportProgress(Request $request)
    {
        $searchData = (object) [
            'sales' => $request->sales,
            'dateMin' => $request->dateMin,
            'dateMax' => $request->dateMax
        ];
        
        if( $searchData->sales != null && $searchData->dateMin != null && $searchData->dateMax != null ) {
            $dataProgress = ProgressWorkplan::where('user_id', $searchData->sales)
                ->whereBetween('date_progress', [$searchData->dateMin, $searchData->dateMax])
                ->with('workplan', 'market_progress', 'sales')
                ->latest()
                ->get();
        } elseif ( $searchData->sales == null && $searchData->dateMin != null && $searchData->dateMax != null ) {
            $dataProgress = ProgressWorkplan::whereBetween('date_progress', [$searchData->dateMin, $searchData->dateMax])
                ->with('workplan', 'market_progress', 'sales')
                ->latest()
                ->get();
        } else {
            $dataProgress = null;
        }

        $pdf = Pdf::loadView('output.recap-progress', compact('searchData', 'dataProgress'))
                    ->setPaper('a4', 'landscape')
                    ->setOption([
                        'dpi' => 150,
                        'defaultFont' => 'sans-serif'
                    ]);
        return $pdf->stream();
    }

    public function purchaseOrder(Request $request)
    {
        $metadata = [
            'title' => 'Download Purchase Order',
            'description' => 'Download',
            'submenu' => 'download-purchase-order',
        ];

        $filterData = (object) [
            'sales' => $request->sales,
            'customer' => $request->customer,
            'dateMin' => $request->dateMin,
            'dateMax' => $request->dateMax
        ];

        if ($filterData->sales != null && $filterData->customer != null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = SalesOrder::where('sales_id', $filterData->sales)
                                    ->where('customer_id', $filterData->customer)
                                    ->whereBetween('order_date', [$filterData->dateMin, $filterData->dateMax])
                                    ->where('approval_id', '3')
                                    ->with('sales', 'customer', 'sales_order_items')
                                    ->latest()
                                    ->paginate(10);
                                    
        // if sales and customer null
        } elseif ($filterData->sales == null && $filterData->customer == null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = SalesOrder::whereBetween('order_date', [$filterData->dateMin, $filterData->dateMax])
                                    ->where('approval_id', '3')
                                    ->with('sales', 'customer', 'sales_order_items')
                                    ->latest()
                                    ->paginate(10);
                                    
        // if customer null
        } elseif ($filterData->sales != null && $filterData->customer == null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = SalesOrder::where('sales_id', $filterData->sales)
                                    ->whereBetween('order_date', [$filterData->dateMin, $filterData->dateMax])
                                    ->where('approval_id', '3')
                                    ->with('sales', 'customer', 'sales_order_items')
                                    ->latest()
                                    ->paginate(10);
                                    
        // if sales null
        } elseif ($filterData->sales == null && $filterData->customer != null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = SalesOrder::where('customer_id', $filterData->customer)
                                    ->whereBetween('order_date', [$filterData->dateMin, $filterData->dateMax])
                                    ->where('approval_id', '3')
                                    ->with('sales', 'customer', 'sales_order_items')
                                    ->latest()
                                    ->paginate(10);
                                    
        } else {
            $results = null;
        }

        $sales = User::latest()->where('branch_id', Auth::user()->branch_id)->where('status', 0)->get();
        $customers = Customer::latest()->where('branch_id', Auth::user()->branch_id)->get();
        return view('download.purchase-order', compact('sales', 'customers', 'results', 'metadata'));
    }

    public function exportPurchaseOrder(Request $request)
    {
        $filterData = (object) [
            'sales' => $request->sales,
            'customer' => $request->customer,
            'dateMin' => $request->dateMin,
            'dateMax' => $request->dateMax
        ];


        if ($filterData->sales != null && $filterData->customer != null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = SalesOrder::where('sales_id', $filterData->sales)
                                    ->where('customer_id', $filterData->customer)
                                    ->whereBetween('order_date', [$filterData->dateMin, $filterData->dateMax])
                                    ->where('approval_id', '3')
                                    ->with('sales', 'customer', 'sales_order_items')
                                    ->latest()
                                    ->get();
                                    
        // if sales and customer null
        } elseif ($filterData->sales == null && $filterData->customer == null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = SalesOrder::whereBetween('order_date', [$filterData->dateMin, $filterData->dateMax])
                                    ->where('approval_id', '3')
                                    ->with('sales', 'customer', 'sales_order_items')
                                    ->latest()
                                    ->get();
                                    
        // if customer null
        } elseif ($filterData->sales != null && $filterData->customer == null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = SalesOrder::where('sales_id', $filterData->sales)
                                    ->whereBetween('order_date', [$filterData->dateMin, $filterData->dateMax])
                                    ->where('approval_id', '3')
                                    ->with('sales', 'customer', 'sales_order_items')
                                    ->latest()
                                    ->get();
                                    
        // if sales null
        } elseif ($filterData->sales == null && $filterData->customer != null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = SalesOrder::where('customer_id', $filterData->customer)
                                    ->whereBetween('order_date', [$filterData->dateMin, $filterData->dateMax])
                                    ->where('approval_id', '3')
                                    ->with('sales', 'customer', 'sales_order_items')
                                    ->latest()
                                    ->get();
                                    
        } else {
            $results = null;
        }


        $pdf = Pdf::loadView('output.purchase-order', compact('filterData', 'results'))
                    ->setPaper('a4', 'landscape')
                    ->setOption([
                        'dpi' => 150,
                        'defaultFont' => 'sans-serif'
                    ]);
        return $pdf->stream();
    }

    public function payment(Request $request)
    {
        $metadata = [
            'title' => 'Download Payment',
            'description' => 'Download',
            'submenu' => 'download-payment',
        ];

        $filterData = (object) [
            'sales' => $request->sales,
            'dateMin' => $request->dateMin,
            'dateMax' => $request->dateMax
        ];

        if ($filterData->sales != null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = SalesOrder::with('recap_invoice', 'sales', 'customer.category_customer')
                        ->where('sales_id', $filterData->sales)
                        ->whereBetween('order_date', [$filterData->dateMin, $filterData->dateMax])
                        ->where('approval_id', '3')
                        ->latest()
                        ->paginate(10);
        } elseif ($filterData->sales == null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = SalesOrder::with('recap_invoice', 'sales', 'customer.category_customer')
                        ->whereBetween('order_date', [$filterData->dateMin, $filterData->dateMax])
                        ->where('approval_id', '3')
                        ->latest()
                        ->paginate(10);
        } else {
            $results = null;
        }

        $sales = User::where('branch_id', Auth::user()->branch_id)->where('status', 0)->get();
        return view('download.payment', compact('sales', 'results', 'metadata'));
    }

    public function exportPaymentPdf(Request $request)
    {
        $filterData = (object) [
            'sales' => $request->sales,
            'dateMin' => $request->dateMin,
            'dateMax' => $request->dateMax
        ];

        if ($filterData->sales != null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = SalesOrder::with('recap_invoice', 'sales', 'customer.category_customer')
                        ->where('sales_id', $filterData->sales)
                        ->whereBetween('order_date', [$filterData->dateMin, $filterData->dateMax])
                        ->where('approval_id', '3')
                        ->latest()
                        ->paginate(10);
        } elseif ($filterData->sales == null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = SalesOrder::with('recap_invoice', 'sales', 'customer.category_customer')
                        ->whereBetween('order_date', [$filterData->dateMin, $filterData->dateMax])
                        ->where('approval_id', '3')
                        ->latest()
                        ->paginate(10);
        } else {
            $results = null;
        }

        $pdf = Pdf::loadView('output.payment', compact('filterData', 'results'))
                    ->setPaper('a4', 'landscape')
                    ->setOption([
                        'dpi' => 150,
                        'defaultFont' => 'sans-serif'
                    ]);
        return $pdf->stream();
    }

    public function exportPaymentExcel(Request $request)
    {
        // Mendapatkan parameter dari request
        $filterData = (object) [
            'sales' => $request->sales,
            'dateMin' => $request->dateMin,
            'dateMax' => $request->dateMax
        ];

        // Menyusun query
        $query = SalesOrder::with('sales', 'customer', 'sales_order_items', 'tax', 'recap_invoice')
            ->whereBetween('order_date', [$filterData->dateMin, $filterData->dateMax]);

        // Jika parameter 'sales' tidak null, tambahkan kondisi pencarian berdasarkan sales
        if ($filterData->sales) {
            $query->where('sales_id', $filterData->sales);
        }

        $salesOrders = $query->latest()->get();
        return Excel::download(new SalesOrderReportExport($salesOrders), 'purchase_order_' . date("Ymd") . '.xlsx');
    }

    public function realisasiKerja(Request $request)
    {
        $filterData = (object) [
            'sales' => $request->sales,
            'customer' => $request->customer,
            'dateMin' => $request->dateMin,
            'dateMax' => $request->dateMax
        ];

        $sales = User::latest()->get();
        $customers = Customer::latest()->get();


        if ($filterData->sales != null && $filterData->customer != null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = Workplan::where('sales_id', $filterData->sales)
                                    ->where('customer_id', $filterData->customer)
                                    ->whereBetween('created_at', [$filterData->dateMin, $filterData->dateMax])
                                    ->where('status', 1)
                                    ->with('sales', 'customer')
                                    ->latest()
                                    ->paginate(4);
        } elseif ($filterData->sales == null && $filterData->customer == null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = Workplan::whereBetween('created_at', [$filterData->dateMin, $filterData->dateMax])
                                    ->where('status', 1)
                                    ->with('sales', 'customer')
                                    ->latest()
                                    ->paginate(4);
                                
        // if customer null
        } elseif ($filterData->sales != null && $filterData->customer == null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = Workplan::where('sales_id', $filterData->sales)
                                ->whereBetween('created_at', [$filterData->dateMin, $filterData->dateMax])
                                ->where('status', 1)
                                ->with('sales', 'customer')
                                ->latest()
                                ->paginate(4);
                                    
        // if sales null
        } elseif ($filterData->sales == null && $filterData->customer != null && $filterData->dateMin != null && $filterData->dateMax != null) {
            $results = Workplan::where('customer_id', $filterData->customer)
                                ->whereBetween('created_at', [$filterData->dateMin, $filterData->dateMax])
                                ->where('status', 1)
                                ->with('sales', 'customer')
                                ->latest()
                                ->paginate(4);
                                    
        } else {
            $results = null;
        }
        return view('download.realisasi-kerja', compact('sales', 'customers', 'results'));
    }
}

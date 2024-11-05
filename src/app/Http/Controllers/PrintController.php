<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ProgressWorkplan;
use App\Models\SalesOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintController extends Controller
{
    public function recapProgress(Request $request)
    {
        
        $salesData = $request->has('sales') ? $request->sales : null;
        $dateMin = $request->has('dateMin') ? $request->dateMin : null;
        $dateMax = $request->has('dateMax') ? $request->dateMax : null;

        $sales = User::where('branch_id', 1)->get();
        
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
        return view('download.recap-progress', compact('sales', 'dataSearch'));
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


        $sales = User::latest()->get();
        $customers = Customer::latest()->get();
        return view('download.purchase-order', compact('sales', 'customers', 'results'));
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
}

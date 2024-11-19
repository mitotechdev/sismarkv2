<?php

namespace App\Http\Controllers;

use App\Charts\GrapSalesBySegmenChart;
use App\Models\Customer;
use App\Models\SalesOrder;
use Illuminate\Support\Facades\Auth;
use App\Charts\MonthlyRevenueChart;
use App\Charts\StatSegmenSalesChart;
use App\Charts\StatsProspectChart;
use App\Charts\TopSellingSalesChart;
use App\Charts\TopSalesProductChart;
use App\Charts\TotalPoPerCustomerChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LarapexChart $larapexChart)
    {
        // Total Revenue
        $salesOrders = SalesOrder::where('approval_id', 3)
                        ->where('branch_id', Auth::user()->branch_id)
                        ->with(['sales_order_items', 'tax', 'recap_invoice']) // Pastikan relasi di-load
                        ->get();
        $totalRevenue = 0;
        $totalOutstanding = 0;
        $totalUninvoiced = 0;
        $totalInvoicePaid = 0;
        
        foreach ($salesOrders as $salesOrder) {
            $totalPo = 0;
            foreach ($salesOrder->sales_order_items as $item) {
                $totalPo += $item->qty * $item->price;
            }
            $ppn = $totalPo * $salesOrder->tax->tax;
            $grandTotal = $totalPo + $ppn; // Total Revenue after tax
            $totalRevenue += $grandTotal;
        
            $invoicePaid = 0;
            $invoiceUnpaid = 0;
            foreach ($salesOrder->recap_invoice as $item) {
                if ($item->date_payment != null) {
                    $invoicePaid += $item->total_payment;
                } else {
                    $invoiceUnpaid += $item->total_payment;
                }
            }
            $totalOutstanding += $invoiceUnpaid;
            $totalInvoicePaid += $invoicePaid;
        
            $totalUninvoiced += max(0, $grandTotal - ($invoicePaid + $invoiceUnpaid));
        }

        

        $metadata = [
            'title' => 'Dashboard',
            'description' => 'Dashboard',
            'submenu' => '',
            //tambah jika ada submenu disini
        ];

        // Total Customer
        $totalCustomer = Customer::where('branch_id', Auth::user()->branch_id)->count();

        // Monthly Revenue Chart
        $chartMonthlyRevenue = (new MonthlyRevenueChart($larapexChart))->build();
        $chartTopSellingSales = (new TopSellingSalesChart($larapexChart))->build();
        $chartTopSalesProduct = (new TopSalesProductChart($larapexChart))->build();
        $grapSalesBySegment = (new GrapSalesBySegmenChart($larapexChart))->build();
        $totalPoPerCustomer = (new TotalPoPerCustomerChart($larapexChart))->build();
        $chartStatsProspect = (new StatsProspectChart($larapexChart))->build();
        $chartStatSegmenSalesChart = (new StatSegmenSalesChart($larapexChart))->build();


        return view('index', [
            'metadata' => $metadata,  
            'totalRevenue' => $totalRevenue,
            'totalOutstandingBalance' => $totalOutstanding,
            'totalEarnings' => $totalInvoicePaid,
            'totalUninvoice' => $totalUninvoiced,
            'chartMonthlyRevenue' => $chartMonthlyRevenue,
            'chartTopSellingSales' => $chartTopSellingSales,
            'chartTopSalesProduct' => $chartTopSalesProduct,
            'grapSalesBySegment' => $grapSalesBySegment,
            'totalPoPerCustomer' => $totalPoPerCustomer,
            'chartStatsProspect' => $chartStatsProspect,
            'chartStatSegmenSalesChart' => $chartStatSegmenSalesChart
        ]);
    }
}

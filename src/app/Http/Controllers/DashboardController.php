<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\SalesOrder;
use Illuminate\Support\Facades\Auth;
use App\Charts\MonthlyRevenueChart;
use App\Charts\TopSellingSalesChart;
use App\Charts\TopSalesProductChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LarapexChart $larapexChart)
    {
        // Total Revenue
        $salesOrder = SalesOrder::where('approval_id', 3)->where('branch_id', Auth::user()->branch_id)->get();
        $totalRevenueOrders = 0;
        foreach ($salesOrder as $orders) {
            $total_price = 0;
            foreach ($orders['sales_order_items'] as $data) {
                $sum = $data->qty * $data->price;
                $total_price += $sum;
            }
            $tax = $orders->tax->tax * $total_price;
            $totalRevenueOrders += $total_price + $tax;
        }

        // Total Customer
        $totalCustomer = Customer::where('branch_id', Auth::user()->branch_id)->count();

        // Monthly Revenue Chart
        $chartMonthlyRevenue = (new MonthlyRevenueChart($larapexChart))->build();
        $chartTopSellingSales = (new TopSellingSalesChart($larapexChart))->build();
        $chartTopSalesProduct = (new TopSalesProductChart($larapexChart))->build();


        return view('index', [
            'totalRevenue' => $totalRevenueOrders,
            'totalCustomer' => $totalCustomer,
            'totalSalesOrder' => $salesOrder->count(),
            'chartMonthlyRevenue' => $chartMonthlyRevenue,
            'chartTopSellingSales' => $chartTopSellingSales,
            'chartTopSalesProduct' => $chartTopSalesProduct
        ]);
    }
}

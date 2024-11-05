<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use App\Models\SalesOrderItem;
use App\Models\ProgressWorkplan;
use App\Charts\StatsProspectChart;
use App\Charts\MonthlyRevenueChart;
use App\Charts\StatSegmenSalesChart;
use App\Charts\TopSalesProductChart;
use App\Charts\TopSellingSalesChart;
use Illuminate\Support\Facades\Auth;
use App\Charts\StatsSegmenPerSalesChart;
use Yajra\DataTables\Facades\DataTables;
use App\Charts\StatsProspectPerSalesChart;
use App\Charts\TopSellingProductBySalesChart;

class ReportController extends Controller
{
    public function reportSalesOrder()
    {
        $salesOrderItems = SalesOrderItem::with('sales_order', 'product')
            ->whereHas('sales_order', function($data) {
                return $data->where('approval_id', 3);
            })
            ->latest()
            ->get();

        $salesOrder = SalesOrder::where('approval_id', 3)->get();

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

        if( request()->ajax() ) {
            return DataTables::of($salesOrderItems)
                ->addIndexColumn()
                ->addColumn('code', function($data) {
                    return $data->sales_order->code;
                })
                ->addColumn('sales', function($data) {
                    return $data->sales_order->sales->name;
                })
                ->addColumn('konsumen', function($data) {
                    return $data->sales_order->customer->name;
                })
                ->addColumn('segmen', function($data) {
                    return $data->sales_order->customer->category_customer->name;
                })
                ->addColumn('product', function($data) {
                    return $data->product->name;
                })
                ->addColumn('qty', function($data) {
                    return number_format($data->qty, '0', ',', '.') . ' '. $data->product->unit;
                })
                ->addColumn('price', function($data) {
                    return 'Rp ' . number_format($data->price, '0', ',', '.');
                })
                ->addColumn('sum_price', function($data) {
                    return 'Rp ' . number_format($data->price*$data->qty, '0', ',', '.');
                })
                ->make();
        }
        return view('pages.report.report-sales-order', compact('totalRevenueOrders', 'salesOrder'));
    }

    public function reportRecapProgress()
    {
        $progress = ProgressWorkplan::with('sales', 'market_progress', 'workplan')->latest()->get();

        if( request()->ajax() ) {
            return DataTables::of($progress)
                ->addIndexColumn()
                ->addColumn('sales', function($data) {
                    return $data->sales->name;
                })
                ->addColumn('date_progress', function($data) {
                    return $data->date_progress->format('d/m/Y');
                })
                ->addColumn('market_progress', function($data) {
                    return $data->market_progress->name;
                })
                ->addColumn('customer_name', function($data) {
                    return $data->workplan->customer->name;
                })
                ->make();
        }
        return view('pages.report.report-recap-progress', compact('progress'));
    }

    public function reportSales(
        TopSalesProductChart $chartTopSalesProduct,
        TopSellingSalesChart $chartTopSellingSales,
        MonthlyRevenueChart $chartMonthlyRevenue,
        StatsProspectChart $chartStatsProspect,
        StatSegmenSalesChart $chartStatSegmenSales,
    )
    {
        $data = SalesOrder::has('sales')->where('branch_id', Auth::user()->branch_id)->get()->groupBy('sales_id')->keys(); //ambil [id sales] dari sales order
        $sales = User::whereIn('id', $data)->get();
        
        return view('pages.report.report-sales', [
            'sales' => $sales,
            'chartTopSalesProduct' => $chartTopSalesProduct->build(),
            'chartTopSellingSales' => $chartTopSellingSales->build(),
            'chartMonthlyRevenue' => $chartMonthlyRevenue->build(),
            'chartStatsProspect' => $chartStatsProspect->build(),
            'chartStatSegmenSales' => $chartStatSegmenSales->build(),
        ]);
    }

    public function reportSalesDetail(User $user)
    {
        $chartStatsProspectSales = app(StatsProspectPerSalesChart::class)->build($user->id);
        $chartTopSellingProductBySales = app(TopSellingProductBySalesChart::class)->build($user->id);
        $chartStatsSegmenPerSales = app(StatsSegmenPerSalesChart::class)->build($user->id);
        return view('pages.report.report-sales-detail', [
            'user' => $user,
            'chartStatsProspectSales' => $chartStatsProspectSales,
            'chartTopSellingProductBySales' => $chartTopSellingProductBySales,
            'chartStatsSegmenPerSales' => $chartStatsSegmenPerSales,
        ]);
    }
}

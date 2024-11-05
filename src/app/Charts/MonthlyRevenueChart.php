<?php

namespace App\Charts;

use App\Models\SalesOrder;
use Illuminate\Support\Facades\Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyRevenueChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        $monthlyRevenue = SalesOrder::where('branch_id', Auth::user()->branch_id)
            ->with('customer', 'sales_order_items', 'tax')
            ->whereYear('order_date', date('Y'))
            ->latest()
            ->get()
            ->groupBy(function ($bill) {
                return date('M', strtotime($bill->order_date));
            });

        // dd($monthlyRevenue);
    
        $revenueByMonth = [];
    
        foreach ($monthlyRevenue as $month => $bills) {
            $revenueByMonth[$month] = $bills->reduce(function ($carry, $bill) {
                
                $total = $bill->sales_order_items->reduce(function ($itemCarry, $item) {
                    return $itemCarry + ($item->qty * $item->price);
                }, 0);
                $ppn = $total * ($bill->tax->tax);
                return $carry + $total + $ppn;
            }, 0);
        }
    
        $monthsOrder = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];
    
        $sortedRevenueByMonth = [];
        foreach ($monthsOrder as $month) {
            $sortedRevenueByMonth[$month] = $revenueByMonth[$month] ?? 0;
        }
        
        $monthNames = array_keys($sortedRevenueByMonth);
        $revenueValues = array_values($sortedRevenueByMonth);
    
        return $this->chart->areaChart()
            ->setTitle('Monthly Revenue of Year ' . date('Y'))
            ->addData('Revenue', $revenueValues)
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10)
            ->setXAxis($monthNames)
            ->setHeight(370);
        
    }
}

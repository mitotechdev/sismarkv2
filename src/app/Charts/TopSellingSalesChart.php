<?php

namespace App\Charts;

use App\Models\SalesOrder;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Auth;

class TopSellingSalesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\HorizontalBar
    {
        $topSalesOrders = SalesOrder::with('sales')
            ->where('approval_id', '3')
            ->where('branch_id', Auth::user()->branch_id)
            ->select('sales_id', DB::raw('count(*) as total_orders'))
            ->groupBy('sales_id')
            ->orderBy('total_orders', 'desc')
            ->limit(5)
            ->get();

        $result = [
            'namesales' => [],
            'totalPO' => []
        ];
        
        // Memasukkan data dari hasil query ke dalam array result
        foreach ($topSalesOrders as $salesOrder) {
            $result['namesales'][] = $salesOrder->sales->name;
            $result['totalPO'][] = $salesOrder->total_orders;
        }
        return $this->chart->horizontalBarChart()
            ->setTitle('Top Selling Sales')
            ->setSubtitle('Sales dengan PO terbanyak')
            ->setColors(['#FFC107', '#D32F2F'])
            ->addData('Total', $result['totalPO'])
            ->setXAxis($result['namesales'])
            ->setHeight(370);
    }
}

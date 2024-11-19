<?php

namespace App\Charts;

use App\Models\SalesOrder;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Auth;

class TotalPoPerCustomerChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // get 10 top PO percustomer
        $topPoPerCustomer = SalesOrder::with('customer', 'sales_order_items.product', 'tax')
                            ->where('approval_id', '3')
                            ->where('branch_id', Auth::user()->branch_id)
                            ->get();
        $dataTotal = [];

        foreach($topPoPerCustomer as $row) {
            $customerID = $row->customer_id;
            if (!isset($dataTotal[$customerID])) {
                $dataTotal[$customerID] = [
                    'name' => $row->customer->name,
                    'total_po' => 0
                ];
            }
            foreach($row['sales_order_items'] as $item) {
                $sumTotalPrice = $item->qty * $item->price;
                $ppn = $sumTotalPrice * $row->tax->tax;
                $grandTotal = $sumTotalPrice + $ppn;
                $dataTotal[$customerID]['total_po'] += $grandTotal;
            }
        }

        usort($dataTotal, function ($a, $b) {
            return $b['total_po'] <=> $a['total_po'];
        });

        // mengambil 10 data teratas dari $dataTotal
        $dataTotal = array_slice($dataTotal, 0, 10);
        $topNameCustomer = [];
        $topPoCustomer = [];

        foreach($dataTotal as $row) {
            $topNameCustomer[] = $row['name'];
            $topPoCustomer[] = $row['total_po'];
        };

        return $this->chart->barChart()
            ->setTitle('Top PO per Customer')
            ->setSubtitle('10 data teratas total nominal PO per Customer')
            ->addData('Total PO', $topPoCustomer)
            ->setXAxis($topNameCustomer)
            ->setHeight(370);
    }
}

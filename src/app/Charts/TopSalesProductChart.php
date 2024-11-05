<?php

namespace App\Charts;

use App\Models\SalesOrder;
use function Termwind\style;

use App\Models\SalesOrderItem;
use Illuminate\Support\Facades\Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class TopSalesProductChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $sales = SalesOrder::with('sales_order_items.product')
            ->where('branch_id', Auth::user()->branch_id)
            ->get();

        $qtyData = [];

        // Loop melalui setiap SalesOrder dan item di dalamnya
        foreach ($sales as $order) {
            foreach ($order->sales_order_items as $item) {
                $productId = $item->product_id;
                $productName = $item->product->code; // Asumsi ada relasi 'product' dan properti 'code'

                if (!isset($qtyData[$productId])) {
                    $qtyData[$productId] = [
                        'name' => $productName,
                        'total_qty' => 0
                    ];
                }

                $qtyData[$productId]['total_qty'] += $item->qty;
            }
        }

        // Mengurutkan produk berdasarkan total qty
        usort($qtyData, function ($a, $b) {
            return $b['total_qty'] <=> $a['total_qty'];
        });

        // Mengambil 5 produk teratas
        $topSalesByQuantity = array_slice($qtyData, 0, 5);

        $topNameProduct = [];
        $topSalesQty = [];
        foreach ($topSalesByQuantity as $item) {
            $topNameProduct[] = $item['name'];
            $topSalesQty[] = $item['total_qty'];
        }

    
        return $this->chart->barChart()
            ->setTitle('Top Sales Product')
            ->setSubtitle('Penjualan teratas produk bahan kimia')
            ->addData('Total Qty', $topSalesQty)
            ->setXAxis($topNameProduct)
            ->setHeight(370);
    }
}

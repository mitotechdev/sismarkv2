<?php

namespace App\Charts;

use App\Models\SalesOrder;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class TopSellingProductBySalesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($id): \ArielMejiaDev\LarapexCharts\HorizontalBar
    {
        // Mengambil data dengan sales_id = 4
        $data = SalesOrder::with(['sales_order_items.product'])
            ->where('sales_id', $id)
            ->get();

        // Menghitung total qty per produk
        $productQuantities = [];

        foreach ($data as $order) {
            foreach ($order->sales_order_items as $item) {
                $productName = $item->product->code; // Pastikan product memiliki kolom 'name'
                $quantity = (int) $item->qty;

                if (!isset($productQuantities[$productName])) {
                    $productQuantities[$productName] = 0;
                }
                $productQuantities[$productName] += $quantity;
            }
        }

        // Mengurutkan produk berdasarkan kuantitas dari tertinggi ke terendah
        arsort($productQuantities);

        // Mendapatkan top 5 produk dengan kuantitas tertinggi
        $topProducts = array_slice($productQuantities, 0, 5, true);

        // Memisahkan nama produk dan total kuantitas untuk dimasukkan ke dalam grafik
        $productNames = array_keys($topProducts);
        $totalQuantities = array_values($topProducts);

        // Membuat grafik horizontal bar
        return $this->chart->horizontalBarChart()
            ->setTitle('Top 5 Produk Terlaris')
            ->setSubtitle('Jumlah Kuantitas Penjualan oleh Sales')
            ->setColors(['#FFC107', '#D32F2F'])
            ->addData('Jumlah Penjualan', $totalQuantities)
            ->setXAxis($productNames)
            ->setHeight(400);
    }
}

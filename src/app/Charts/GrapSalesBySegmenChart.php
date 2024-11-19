<?php

namespace App\Charts;

use App\Models\SalesOrder;
use App\Models\CategoryCustomer;
use Illuminate\Support\Facades\Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class GrapSalesBySegmenChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $categories = CategoryCustomer::all();
        $categoryTotals = [];

        // Inisialisasi setiap kategori dengan nilai awal 0
        foreach ($categories as $category) {
            $categoryTotals[$category->name] = 0;
        }

        // Mendapatkan semua sales orders dengan kategori pelanggan
        $salesOrders = SalesOrder::with('sales_order_items', 'customer.category_customer')->where('branch_id', Auth::user()->branch_id)->get();

        // Iterasi melalui setiap sales order untuk menghitung total berdasarkan kategori
        $totalRevenue = 0;
        foreach ($salesOrders as $order) {
            // Mendapatkan kategori pelanggan dari order ini
            $categoryName = $order->customer->category_customer->name;

            // Iterasi melalui setiap item di dalam sales order untuk menghitung subtotalnya
            foreach ($order->sales_order_items as $item) {
                $subtotal = $item->qty * $item->price;  // Menghitung subtotal item
                $ppn = $subtotal * $order->tax->tax; // menghitung ppn
                $grandTotal = $subtotal + $ppn;
                $totalRevenue += $subtotal + $ppn;
                $categoryTotals[$categoryName] += $grandTotal;  // Menambahkan ke total kategori
            }
        }

        $data = [];
        $labels = [];

        // Mengisi data dan label dari hasil total per kategori
        foreach ($categoryTotals as $category => $total) {
            if($totalRevenue != 0) {
            $labels[] = $category; // Nama kategori untuk label
            $data[] = floor(($total / $totalRevenue) * 100);      // Total penjualan untuk data
            }
        }
        

        return $this->chart
            ->pieChart()
            ->setTitle('Sales By Segment')
            ->setSubtitle('Akumulasi Penjualan (%)')
            ->addData($data)
            ->setLabels($labels)
            ->setHeight(380);
    }
}

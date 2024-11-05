<?php

namespace App\Charts;

use App\Models\SalesOrder;
use Illuminate\Support\Facades\Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class StatSegmenSalesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PolarAreaChart
    {
        $data = SalesOrder::with('segmen')->where('branch_id', Auth::user()->branch_id)->get();

        // Array untuk menyimpan hasil perhitungan jumlah PO per segmen
        $segmentCounts = [];

        // Menghitung jumlah PO per segmen
        foreach ($data as $order) {
            $segmentName = $order->segmen->name; // Mengambil nama segmen

            if (!isset($segmentCounts[$segmentName])) {
                $segmentCounts[$segmentName] = 0; // Inisialisasi jika segmen belum ada
            }
            $segmentCounts[$segmentName]++; // Menambah jumlah PO untuk segmen ini
        }

        // Menyiapkan data dan label untuk chart
        $labels = array_keys($segmentCounts); // Nama segmen
        $dataPoints = array_values($segmentCounts); // Jumlah PO per segmen

        // Mengembalikan chart dengan data yang sudah disiapkan
        return $this->chart
            ->polarAreaChart()
            ->setTitle('Total Purchase Order')
            ->setSubtitle('Data akumulasi purchase order per segmen')
            ->addData($dataPoints)
            ->setLabels($labels)
            ->setHeight(370);
    }
}

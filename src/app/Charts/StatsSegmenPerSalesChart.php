<?php

namespace App\Charts;

use App\Models\SalesOrder;
use Illuminate\Support\Facades\Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class StatsSegmenPerSalesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($id): \ArielMejiaDev\LarapexCharts\PolarAreaChart
    {
        // Mengambil data dengan sales_id = 4 dan memuat relasi segmen
        $data = SalesOrder::with('segmen')->where('sales_id', $id)->where('branch_id', Auth::user()->branch_id)->get();

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

        // Membatasi data dan label jika lebih dari 3 segmen
        if (count($labels) > 3) {
            $labels = array_slice($labels, 0, 3);
            $dataPoints = array_slice($dataPoints, 0, 3);
        }

        // Mengembalikan chart dengan data yang sudah disiapkan
        return $this->chart
            ->polarAreaChart()
            ->setTitle('Stats PO per segmen')
            ->setSubtitle('Data PO per segmen.')
            ->addData($dataPoints)
            ->setLabels($labels);
    }
}

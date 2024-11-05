<?php

namespace App\Charts;

use App\Models\Workplan;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class StatsProspectPerSalesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($id): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $data = Workplan::with('market_progress')
        ->where('market_progress_id', '!=', null)
        ->where('sales_id', $id)
        ->get();

        // Mengelompokkan data berdasarkan sales_id dan status market_progress
        $salesStatusCounts = $data->groupBy('market_progress.status')->map->count();

        $xAxis = ['Prospect', 'Hot Prospect', 'Loss Prospect'];
        $dataValues = [
            $salesStatusCounts['Prospect'] ?? 0, 
            $salesStatusCounts['Hot Prospect'] ?? 0, 
            $salesStatusCounts['Loss Prospect'] ?? 0
        ];
        
        return $this->chart->barChart()
            ->setTitle('Stats Prospect')
            ->addData('Status', $dataValues)
            ->setXAxis($xAxis)
            ->setHeight(370);
    }
}

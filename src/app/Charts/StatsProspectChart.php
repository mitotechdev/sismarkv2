<?php

namespace App\Charts;

use App\Models\Workplan;
use Illuminate\Support\Facades\Auth;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class StatsProspectChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $data = Workplan::with('market_progress')
                ->where('market_progress_id', '!=', null)
                ->where('branch_id', Auth::user()->branch_id)
                ->get();

        $statusCounts = $data->groupBy('market_progress.status')->map->count();

        $xAxis = ['Prospect', 'Hot Prospect', 'Loss Prospect'];
        $dataValues = [
            $statusCounts['Prospect'] ?? 0, 
            $statusCounts['Hot Prospect'] ?? 0, 
            $statusCounts['Loss Prospect'] ?? 0
        ];
        return $this->chart->barChart()
            ->setTitle('Statistik Prospect')
            ->setSubtitle('Statistik jumlah data per status progress')
            ->addData('Jumlah', $dataValues)
            ->setXAxis($xAxis)
            ->setHeight(370);
    }
}

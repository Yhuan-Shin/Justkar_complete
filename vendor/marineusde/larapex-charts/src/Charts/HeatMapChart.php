<?php

namespace marineusde\LarapexCharts\Charts;

use marineusde\LarapexCharts\Contracts\MustAddComplexData;
use marineusde\LarapexCharts\LarapexChart;
use marineusde\LarapexCharts\Traits\ComplexChartDataAggregator;

class HeatMapChart extends LarapexChart implements MustAddComplexData
{
    use ComplexChartDataAggregator;

    public function __construct()
    {
        parent::__construct();
        $this->type = 'heatmap';
    }

    public function addHeat(string $name, array $data): HeatMapChart
    {
        return $this->addData($name, $data);
    }
}

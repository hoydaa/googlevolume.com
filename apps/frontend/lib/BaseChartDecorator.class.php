<?php

/**
 * Base chart decorater
 *
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
abstract class BaseChartDecorator implements ChartDecorator
{

    public function decorate($chart) {
        self::formatYLabels($chart);
        $this->selfDecorate($chart);
    }
    
    abstract public function selfDecorate($chart);
    
    public static function formatYLabels($chart)
    {
        $y_labels = $chart->getSeries()->getYLabels();
        for($i = 0; $i < sizeof($y_labels); $i++)
        {
            //$y_labels[$i] = number_format($y_labels[$i]);
            if($y_labels[$i] / 1000000000 > 1) {
                $y_labels[$i] = number_format($y_labels[$i]/1000000000, 2) . " B";
            }
            else if($y_labels[$i] / 1000000 > 1) {
                $y_labels[$i] = number_format($y_labels[$i]/1000000, 2) . " M";
            }
            else if($y_labels[$i] / 1000 > 1) {
                $y_labels[$i] = number_format($y_labels[$i]/1000, 2) . " K";
            }
        }
        $chart->getSeries()->setYLabels($y_labels);
    }

}

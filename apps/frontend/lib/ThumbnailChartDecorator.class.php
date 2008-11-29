<?php

class ThumbnailChartDecorator implements ChartDecorator
{
    
    private $xLabels = null;

    public function __construct($xLabels = null)
    {
        $this->xLabels = $xLabels;
    }

    public function setXLabels($xLabels)
    {
        $this->xLabels = $xLabels;
    }

    public function decorate($chart)
    {
        $chart->setWidth('250');
        $chart->setHeight('125');
        $chart->getSeries()->autoSetYLabels(2);
        $chart->getSeries()->setSerieLabelsEnabled(false);
        $chart->setTitle(null);
        if($this->xLabels)
        {
            $chart->getSeries()->setXLabels($this->xLabels);
        }
        //return $chart;
    }

}

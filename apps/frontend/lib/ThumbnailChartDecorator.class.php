<?php

class ThumbnailChartDecorator extends BaseChartDecorator
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

    public function selfDecorate($chart)
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
        self::formatYLabels($chart);
    }

}

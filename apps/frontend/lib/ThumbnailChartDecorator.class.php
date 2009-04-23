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
        
        $labels = null;
        if($this->xLabels) {
            $labels = $this->xLabels; 
        } else {
            $labels = array('start', 'end');
        }
        if($this->frequency) {
            array_splice($labels, 1, 0, '('.$this->frequency.')'); 
        }
        
        $chart->getSeries()->setXLabels($labels);
        
        self::formatYLabels($chart);
    }

}

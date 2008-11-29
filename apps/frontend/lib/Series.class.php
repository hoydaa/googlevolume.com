<?php

class Series
{
    
    protected $colors = array('0000ff', '008000', 'ff0000', 'ffff00');

    private $series = array();

    private $x_labels = array();

    private $y_labels = array();

    private $max_of_all = null;

    private $min_of_all = null;

    private $markers_enabled = true;

    private $x_labels_enabled = true;

    private $y_labels_enabled = true;

    private $scale_min = null;

    private $scale_max = null;

    private $serie_labels_enabled = true;

    
    public function getColors()
    {
        return $this->colors;
    }

    public function setColors($colors)
    {
        $this->colors = $colors;
    }

    public function setXLabels($x_labels)
    {
        $this->x_labels = $x_labels;
    }

    public function setYLabels($y_labels)
    {
        $this->y_labels = $y_labels;
    }

    public function setMarkersEnabled($markers_enabled)
    {
        $this->markers_enabled = $markers_enabled;
    }

    public function setSerieLabelsEnabled($enabled)
    {
        $this->serie_labels_enabled = $enabled;
    }

    public function addSerie($serie)
    {
        $serie->setColor($this->colors[sizeof($this->series)%sizeof($this->colors)]);
        $this->series[] = $serie;
    }

    public function getSeries()
    {
        return $this->series;
    }

    public function normalize()
    {
        $this->calculateMin();
        foreach($this->series as $serie)
        {
            $serie->normalize($this->calculateMax());
        }
    }

    private function calculateMax()
    {
        if(!$this->max_of_all)
        {
            $max_of_series = array();
            foreach($this->series as $serie)
            {
                $max_of_series[] = $serie->calculateMax();
            }
            $this->max_of_all = max($max_of_series);
        }
        return $this->max_of_all;
    }

    private function calculateMin()
    {
        if(!$this->min_of_all)
        {
            $min_of_series = array();
            foreach($this->series as $serie)
            {
                $min_of_series[] = $serie->calculateMin();
            }
            $this->min_of_all = min($min_of_series);
        }
        return $this->min_of_all;
    }

    public function autoSetYLabels($count = 5)
    {
        $diff = ($this->calculateMax() - $this->calculateMin());
        $step = Utils::find_maximum_decimal_factor($diff) / 10;
        $up = ceil($this->calculateMax() / $step) * $step;
        $down  = floor($this->calculateMin() / $step) * $step;
        $diff = ($up - $down) / $count;
        $this->y_labels = array();
        for($i = 0; $i < $count + 1; $i++)
        {
            $this->y_labels[] = number_format($down + $diff * $i);
        }
        $this->scale_min = round($down / $this->calculateMax() * 100, 1);
        $this->scale_max = round($up / $this->calculateMax() * 100, 1);
    }

    public function __toString()
    {
        $rtn = '';
        if(sizeof($this->series) > 0)
        {
            // chart data
            $series_text = 'chd=t:' . implode('|', $this->series);
            $rtn .= '&' . $series_text;

            // labels, colors, markers
            $labels_arr = array();
            $colors_arr = array();
            $markers_arr = array();
            $counter = 0;
            foreach($this->series as $serie)
            {
                $labels_arr[] = $serie->getLabel();
                $colors_arr[] = $serie->getColor();
                $markers_arr[] = 'o,'.$serie->getColor().','.$counter.',-1,6';
                $counter++;
            }
            // serie labels
            if($this->serie_labels_enabled)
            {
                $labels_text = 'chdl=' . implode('|', $labels_arr);
                $rtn .= '&' . $labels_text;
            }
            $colors_text = 'chco=' . implode(',', $colors_arr);
            $rtn .= '&' . $colors_text;
            if($this->markers_enabled)
            {
                $rtn .= '&chm=' . implode('|', $markers_arr);
            }
             
            if($this->scale_min)
            {
                $rtn .= '&chds=' . $this->scale_min . ',' . $this->scale_max;
            } else
            {
                $rtn .= '&chds=' . round(($this->calculateMin() / $this->calculateMax() * 100), 1) . ',100';
            }
        }

        $rtn .= '&chxt=x,y';

        if($this->x_labels || $this->y_labels)
        {
            $rtn .= '&chxl=';
            if($this->x_labels)
            {
                $rtn .= '0:|' . implode('|', $this->x_labels);
            }

            if($this->y_labels)
            {
                $rtn .= '|1:|' . implode('|', $this->y_labels);
            }
        }

        if($this->x_labels && $this->y_labels)
        {
            $rtn .= '&chg=' . (round(100 / (sizeof($this->x_labels) - 1), 2) - 0.02) . ',' . (round(100 / (sizeof($this->y_labels) - 1), 2) - 0.02);
        }

        return $rtn;
    }

}

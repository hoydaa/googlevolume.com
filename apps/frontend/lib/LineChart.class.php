<?php

class LineChart extends BaseChart
{

    private $series = null;

    public function getSeries()
    {
        return $this->series;
    }

    public function setSeries($series)
    {
        $this->series = $series;
    }

    protected function getStringRepresentation()
    {
        // chart type
        $rtn = 'cht=lc';

        // series
        if($this->series != null)
        {
            $rtn .= $this->series;
        }

        return $rtn;
    }

}

<?php

/**
 * Line chart
 * 
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
class LineChart extends BaseChart
{

    /**
     * Serie array
     *
     * @var array
     */
    private $series = null;

    /**
     * Returns series
     *
     * @return series
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Sets series
     *
     * @param array $series
     */
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

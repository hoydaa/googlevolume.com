<?php

class LineChart extends BaseChart
{
  
  private $series = null;
  
  public function setSeries($series)
  {
    $this->series = $series;
  }
  
  protected function getStringRepresentation()
  {
    $rtn = 'cht=lc';
    
    if($this->series != null)
    {
      $rtn .= $this->series;
    }
    
    return $rtn;
  }

}
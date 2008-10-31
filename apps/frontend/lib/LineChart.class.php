<?php

class LineChart extends BaseChart
{

  private $series = array();
  
  public function addSerie($serie)
  {
    $this->series[] = $serie;
  }
  
  protected function getStringRepresentation()
  {
    $rtn = 'cht=lc';
    
    if(sizeof($this->series) > 0)
    {
      $series_text = 'chd=t:' . implode('|', $this->series);
      $rtn .= '&' . $series_text;
      
      $labels_arr = array();
      foreach($this->series as $serie)
      {
        $labels_arr[] = $serie->getLabel();
      }
      $labels_text = 'chdl=' . implode('|', $labels_arr);
      $rtn .= '&' . $labels_text;
    }
    
    return $rtn;
  }

}
<?php

class LineChart extends BaseChart
{

  private $series = array();
  
  public function addSerie($serie)
  {
    $serie->setColor($this->colors[sizeof($this->series)%sizeof($this->colors)]);
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
      $colors_arr = array();
      foreach($this->series as $serie)
      {
        $labels_arr[] = $serie->getLabel();
        $colors_arr[] = $serie->getColor();
      }
      $labels_text = 'chdl=' . implode('|', $labels_arr);
      $rtn .= '&' . $labels_text;
      $colors_text = 'chco=' . implode(',', $colors_arr);
      $rtn .= '&' . $colors_text;
      
      $colors_arr = array();
     
    }
    
    $rtn .= '&chxt=x,y';
    //$rtn .= '&chxr=0,0,200|1,0,500';
    
    return $rtn;
  }
  
  public function normalize()
  {
    $max_of_series = array();
    foreach($this->series as $serie)
    {
      $max_of_series[] = $serie->getMax();
    } 
    $max_of_all = max($max_of_series);
    foreach($this->series as $serie)
    {
      $serie->normalize($max_of_all);
    }
  }

}
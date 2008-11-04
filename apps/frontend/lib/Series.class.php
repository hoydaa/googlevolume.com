<?php

class Series
{
  
  private $series = array();
  protected $colors = array('ff0000', '00ff00', '0000ff');
  private $x_labels = array();
  private $y_labels = array();
  private $max_of_all = null;
  private $min_of_all = null;

  //$rtn .= '&chxr=0,0,200|1,0,500';
  //$rtn .= '&chxl=0:|1|2|3|4'

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

  public function addSerie($serie)
  {
    $serie->setColor($this->colors[sizeof($this->series)%sizeof($this->colors)]);
    $this->series[] = $serie;
  }
  
  public function normalize()
  {
    if(!$this->max_of_all)
    {
      $this->calculateMax();
    }
    if(!$this->min_of_all)
    {
      $this->calculateMin();
    }
    foreach($this->series as $serie)
    {
      $serie->normalize($this->max_of_all);
    }
  }
  
  private function calculateMax()
  {
    $max_of_series = array();
    foreach($this->series as $serie)
    {
      $max_of_series[] = $serie->getMax();
    } 
    $this->max_of_all = max($max_of_series);
  }
  
  private function calculateMin()
  {
    $min_of_series = array();
    foreach($this->series as $serie)
    {
      $min_of_series[] = $serie->getMin();
    }
    $this->min_of_all = min($min_of_series);
  }
  
  public function autoSetYLabels($count = 3)
  {
    if(!$this->max_of_all)
    {
      $this->calculateMax();
    }
    if(!$this->min_of_all)
    {
      $this->calculateMin();
    }
    $this->y_labels = array();
    $this->y_labels[] = 0;
    for($i = 1; $i < $count - 1; $i++)
    {
      $this->y_labels[] = round($this->max_of_all / ($count - 1), 1) * $i;
    }
    $this->y_labels[] = $this->max_of_all;
    //$this->y_labels = array(0, round($this->max_of_all / 2.0, 0), $this->max_of_all);
  }
  
  public function __toString() 
  {
    $rtn = '';
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
    
    return $rtn;
  }
  
}
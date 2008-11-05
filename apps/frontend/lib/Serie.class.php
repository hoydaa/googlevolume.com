<?php

class Serie
{

  private $label = null;
  private $data = array();
  private $color = '00ff00';
  private $markers_enabled = true;
  
  public function __construct($data = array(), $label = null)
  {
    $this->data = $data;
    $this->label = $label;
  }
  
  public function getLabel()
  {
    return $this->label;
  }
  
  public function setLabel($label)
  {
    $this->label = $label;
  }
  
  public function getColor()
  {
    return $this->color;
  }
  
  public function setColor($color)
  {
    $this->color = $color;
  }
  
  public function isMarkersEnabled()
  {
    return $this->markers_enabled;
  }
  
  public function setMarkersEnabled($markers_enabled) 
  {
    $this->markers_enabled = $markers_enabled;
  }
  
  public function addData($data) 
  {
    $this->data[] = $data;
  }
  
  public function calculateMax()
  {
    return max($this->data);
  }
  
  public function calculateMin()
  {
    $temp = array();
    foreach($this->data as $value)
    {
      if($value != -1)
      {
        $temp[] = $value;
      }
    }
    return min($temp);
  }
  
  public function normalize($max)
  {
    for($i = 0; $i < sizeof($this->data); $i++)
    {
      $this->data[$i] =  round(100 / $max * $this->data[$i], 1);
    }
  }
  
  public function __toString()
  {
    return $this->data ? implode(',', $this->data) : '';
  }
  
}
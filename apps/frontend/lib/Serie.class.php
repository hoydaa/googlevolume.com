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
  
  public function setData($data)
  {
    $this->data = $data;
  }
  
  public function setLabel($label)
  {
    $this->label = $label;
  }
  
  public function addData($data) 
  {
    $this->data[] = $data;
  }
  
  public function getLabel()
  {
    return $this->label;
  }
  
  public function setColor($color)
  {
    $this->color = $color;
  }
  
  public function getColor()
  {
    return $this->color;
  }
  
  public function isMarkersEnabled()
  {
    return $this->markers_enabled;
  }
  
  public function setMarkersEnabled($markers_enabled) 
  {
    $this->markers_enabled = $markers_enabled;
  }
  
  public function __toString()
  {
    return $this->data ? implode(',', $this->data) : '';
  }
  
  public function getMax()
  {
    return max($this->data);
  }
  
  public function getMin()
  {
    return min($this->data);
  }
  
  public function normalize($max)
  {
    for($i = 0; $i < sizeof($this->data); $i++)
    {
      $this->data[$i] =  round(100 / $max * $this->data[$i], 1);
    }
  }
}
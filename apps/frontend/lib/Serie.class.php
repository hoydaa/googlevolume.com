<?php

class Serie
{

  private $label = null;
  private $data = array();
  
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
  
  public function __toString()
  {
    return $this->data ? implode(',', $this->data) : '';
  }
  
}
<?php

abstract class BaseChart
{

  const URL = 'http://chart.apis.google.com/chart';
  const DEFAULT_WIDTH = 500;
  const DEFAULT_HEIGHT = 300;

  private $title = null;
  private $width = self::DEFAULT_WIDTH;
  private $height = self::DEFAULT_HEIGHT;
  protected $colors = array('ff0000', '00ff00', '0000ff');
  
  public function setTitle($title)
  {
    $this->title = $title;
  }
  
  public function getTitle()
  {
    return $this->title;
  }
  
  public function setWidth($width)
  {
    $this->width = $width;
  }
  
  public function getWidth() 
  {
    return $this->width;
  }
  
  public function setHeight($height)
  {
    $this->height = $height;
  }
  
  public function getHeight()
  {
    return $this->height;
  }
  
  public function setColors($colors)
  {
    $this->colors = $colors;
  }
  
  public function __toString()
  {
    $representation = $this->getStringRepresentation();
    $rtn = 'chs=' . $this->width . 'x' . $this->height;
    if($this->title)
    {
      $rtn .= '&' . 'chtt=' . $this->title;
    }
    
    $rtn .= '&' . $representation;
    return self::URL . '?' . $rtn;
  }
  
  abstract protected function getStringRepresentation();

}
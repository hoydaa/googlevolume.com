<?php

abstract class BaseChart
{
  const URL = 'http://chart.apis.google.com/chart';
  const DEFAULT_WIDTH = 600;
  const DEFAULT_HEIGHT = 300;



  private $title = null;
  
  private $title_font = 14;
  
  private $width = self::DEFAULT_WIDTH;
  
  private $height = self::DEFAULT_HEIGHT;
  
  
  
  public function getTitle()
  {
    return $this->title;
  }
  
  public function setTitle($title)
  {
    $this->title = $title;
  }
  
  public function getWidth() 
  {
    return $this->width;
  }
  
  public function setWidth($width)
  {
    $this->width = $width;
  }
  
  public function getHeight()
  {
    return $this->height;
  }
  
  public function setHeight($height)
  {
    $this->height = $height;
  }
  
  public function getTitleFont()
  {
    return $this->title_font;
  }
  
  public function setTitleFont($font)
  {
    $this->title_font = $font;
  }
  
  
  
  public function __toString()
  {
    $representation = $this->getStringRepresentation();
    
    // chart size
    $rtn = 'chs=' . $this->width . 'x' . $this->height;
    
    // chart title
    if($this->title)
    {
      $rtn .= '&' . 'chtt=' . $this->title;
      if($this->title_font != 14)
      {
        $rtn .= '&chts=000000,' . $this->title_font;
      }
    }
    
    $rtn .= '&' . $representation;
    return self::URL . '?' . $rtn;
  }
  
  private function generate_filename()
  {
    $this->filename = urlencode($this->title).'.png';
  }

  private function saveImage()
  {
    if(!$this->filename) $this->generate_filename();
    /* get image file */
    //$this->chart_url = htmlspecialchars($this->chart_url);
    //$this->chart_url = urlencode($this->chart_url);
  
    if(function_exists('file_get_contents') && $this->image_content = file_get_contents($this->chart_url)) 
    $this->image_fetched = true;
    
    if(!$this->image_fetched)
    {
      if($fp = fopen($this->chart_url,'r'))
      {
        $this->image_content = fread($fp);
        fclose($fp);
        $this->image_fetched = true;
      }
    }
  
    /* write image to cache */
    if($this->image_fetched)
    {
      $fp = fopen($this->filename,'w+');
      if($fp) 
      {
        fwrite($fp,$this->image_content);
        fclose($fp);
      }
      else { return false; }    
    }
    else { return false; }
    return true;
  }

  abstract protected function getStringRepresentation();
}
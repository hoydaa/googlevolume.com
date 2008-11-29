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
    
    private $cacheable = null;
    
    
    public function __construct($cacheable = false) {
        $this->cacheable = $cacheable;
    }

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
    
    public function isCacheable() 
    {
        return $this->cacheable;    
    }

    public function setCacheable($cacheable)
    {
        $this->cacheable = $cacheable;
    }
    
    public function setTitleFont($font)
    {
        $this->title_font = $font;
    }

    private function getGoogleUrl()
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

    public function __toString()
    {
        return $this->saveAndReturnUrl();
    }

    private function saveAndReturnUrl()
    {
        $google_url = $this->getGoogleUrl();

        if($this->cacheable)
        {
            $relative_url = md5($google_url) . '.png';
            $local_url = sfConfig::get('app_web_images_charts') . '/' . $relative_url;
    
            if(!file_exists($local_url))
            {
                file_put_contents($local_url, file_get_contents($google_url));
            }
    
            return 'http://www.mytrends.com/images/charts/' . $relative_url;
        } else
        {
            return $google_url;
        }
    }

    abstract protected function getStringRepresentation();
}

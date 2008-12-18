<?php

abstract class BaseChart
{
    /**
     * Base url for google chart api
     */
    const URL = 'http://chart.apis.google.com/chart';

    /**
     * Default chart width in pixels
     */
    const DEFAULT_WIDTH = 600;

    /**
     * Default chart height in pixels
     */
    const DEFAULT_HEIGHT = 300;

    /**
     * Top direction for placement
     */
    const PLACEMENT_TOP = 1;

    /**
     * Bottom direction for placement
     */
    const PLACEMENT_BOTTOM = 2;

    /**
     * Left direction for placement
     */
    const PLACEMENT_LEFT = 3;

    /**
     * Right direction for placement
     */
    const PLACEMENT_RIGHT = 4;


    /**
     * Title of the chart
     *
     * @var string
     */
    private $title = null;

    /**
     * Font size for the chart title
     *
     * @var integer
     */
    private $title_font = 14;

    /**
     * Width of the chart in pixels
     *
     * @var integer
     */
    private $width = self::DEFAULT_WIDTH;

    /**
     * Height of the chart in pixels
     *
     * @var integer
     */
    private $height = self::DEFAULT_HEIGHT;

    /**
     * If the chart will be cached or not
     *
     * @var boolean
     */
    private $cacheable = null;


    /**
     * Constructs a new chart object
     *
     * @param boolean $cacheable
     */
    public function __construct($cacheable = false) {
        $this->cacheable = $cacheable;
    }

    /**
     * Returns title of the chart
     *
     * @return title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets title of the chart
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns width of the chart
     *
     * @return width
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Sets width of the chart
     *
     * @param integer $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Returns height of the chart
     *
     * @return height
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Sets height of the chart
     *
     * @param integer $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * Returns font size for the chart title
     *
     * @return size
     */
    public function getTitleFont()
    {
        return $this->title_font;
    }

    /**
     * Sets font size for the chart title
     *
     * @param integer $font
     */
    public function setTitleFont($font)
    {
        $this->title_font = $font;
    }

    /**
     * Returns if the chart will be cached
     *
     * @return cacheable
     */
    public function isCacheable()
    {
        return $this->cacheable;
    }

    /**
     * Sets it the chart will be cached
     *
     * @param boolean $cacheable
     */
    public function setCacheable($cacheable)
    {
        $this->cacheable = $cacheable;
    }

    /**
     * Returns the google url for the chart
     *
     * @return google_url
     */
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

    /**
     * Returns the string representation of the chart
     *
     * @return string_representation
     */
    public function __toString()
    {
        return $this->saveAndReturnUrl();
    }

    /**
     * Saves the chart and returns the url for the chart
     *
     * @return url
     */
    private function saveAndReturnUrl()
    {
        $google_url = $this->getGoogleUrl();

        // if chart is cacheable save the image to temp and return the url, otherwise only return the url.
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

    /**
     * Custom string representation of the chart
     */
    abstract protected function getStringRepresentation();
}

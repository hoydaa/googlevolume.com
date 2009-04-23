<?php

/**
 * Holds data and options related with a serie
 *
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
class Serie
{
    
    /**
     * Label of the serie
     *
     * @var string
     */
    private $label = null;

    /**
     * Data of the serie
     *
     * @var array
     */
    private $data = array();

    /**
     * Color of the serie
     *
     * @var string
     */
    private $color = '00ff00';

    /**
     * If markers are enabled
     *
     * @var boolean
     */
    private $markers_enabled = true;

    private $thickness = 1;
    
    /**
     * Constructs a new serie object according to the given data and label.
     *
     * @param array $data
     * @param string $label
     */
    public function __construct($data = array(), $label = null)
    {
        $this->data = $data;
        $this->label = $label;
    }

    public function getThickness() {
        return $this->thickness;
    }
    
    public function setThickness($thickness) {
        $this->thickness = $thickness;
    }
    
    public function getStyleText() {
        return $this->thickness . ",0,0";
    }
    
    /**
     * Returns the label of the serie
     *
     * @return label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets the label of the serie
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Returns the color of the serie
     *
     * @return color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Sets the color of the serie
     *
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * Returns if markers enabled
     *
     * @return markers enabled
     */
    public function isMarkersEnabled()
    {
        return $this->markers_enabled;
    }

    /**
     * Sets if markers enabled
     *
     * @param boolean $markers_enabled
     */
    public function setMarkersEnabled($markers_enabled)
    {
        $this->markers_enabled = $markers_enabled;
    }

    /**
     * Adds data to the serie
     *
     * @param integer $data
     */
    public function addData($data)
    {
        $this->data[] = $data;
    }

    public function isMoreThanOne() {
        $counter = 0;
        foreach($this->data as $item) {
            if($item != "-1") {
                $counter++;
            }
            if($counter > 1) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Calculates the maximum
     *
     * @return maximum
     */
    public function calculateMax()
    {
        return max($this->data);
    }

    /**
     * Calculates the minimum
     *
     * @return minimum
     */
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

    /**
     * Normalizes the serie data according to the maximum and minimum values
     *
     * @param $max
     */
    public function normalize($max)
    {
        for($i = 0; $i < sizeof($this->data); $i++)
        {
            if($this->data[$i] != -1)
            {
                $this->data[$i] =  round(100 / $max * $this->data[$i], 1);
            }
        }
    }

    /**
     * Retuns the string representation for the serie
     *
     * @return string
     */
    public function __toString()
    {
        return $this->data ? implode(',', $this->data) : '';
    }

}

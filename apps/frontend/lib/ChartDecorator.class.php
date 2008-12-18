<?php

/**
 * Decorator for charts
 *
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
interface ChartDecorator
{
    
    /**
     * Decorates the chart given as a parameter
     *
     * @param BaseChart $chart
     */
    public function decorate($chart);

}

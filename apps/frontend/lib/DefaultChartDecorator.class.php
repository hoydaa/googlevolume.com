<?php

/**
 * Default chart decorater
 *
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
class DefaultChartDecorator implements ChartDecorator
{

    public function decorate($chart) {
        $chart->getSeries()->setSerieLabelsPosition(BaseChart::PLACEMENT_BOTTOM);
        $chart->setWidth(580);
    }

}

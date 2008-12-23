<?php

/**
 * Default chart decorater
 *
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
class DefaultChartDecorator extends BaseChartDecorator
{

    public function selfDecorate($chart) {
        $chart->getSeries()->setSerieLabelsPosition(BaseChart::PLACEMENT_BOTTOM);
        $chart->setWidth(580);
    }

}

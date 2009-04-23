<?php

/**
 * Default chart decorater
 *
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
class DefaultChartDecorator extends BaseChartDecorator
{

    public function selfDecorate($chart) {
        $chart->setTitle($chart->getTitle() . ($this->frequency ? ' ('.$this->frequency.')' : '') . "|" . "by www.googlevolume.com");
        $chart->getSeries()->setSerieLabelsPosition(BaseChart::PLACEMENT_BOTTOM);
        $chart->setWidth(580);
    }

}

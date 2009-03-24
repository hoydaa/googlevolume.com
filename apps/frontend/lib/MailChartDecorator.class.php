<?php

/**
 * Default chart decorater
 *
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
class MailChartDecorator extends BaseChartDecorator
{
    
    public function selfDecorate($chart) {
        $chart->setTitle($chart->getTitle() . "|" . "by www.googlevolume.com");
        $chart->setCacheable(true);
        $chart->getSeries()->setSerieLabelsPosition(BaseChart::PLACEMENT_BOTTOM);
        $chart->setWidth(580);
    }

}

<?php
/**
 * Default chart decorater
 *
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
class PermanentChartDecorator extends BaseChartDecorator
{

    public function selfDecorate($chart) {
        $chart->setTitle($chart->getTitle() . "|" . "by www.googlevolume.com");
        $chart->getSeries()->setSerieLabelsPosition(BaseChart::PLACEMENT_BOTTOM);
        $chart->setWidth(580);
        $chart->setCacheable(true);
    }

}
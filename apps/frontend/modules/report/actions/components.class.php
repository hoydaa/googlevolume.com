<?php

class reportComponents extends sfComponents
{
    public function executeChart($request)
    {
        $decorator = new DefaultChartDecorator();
        $this->line_chart = ReportPeer::getReportChartt($this->report, $decorator);
    }

    public function executeMiniChart($request)
    {   
        $interval = ReportPeer::getMeasurementInterval($this->report->getId());
        $x_labels = array($interval['first'], $interval['last']);
        $decorator = new ThumbnailChartDecorator($x_labels);
        $this->chart = ReportPeer::getReportChartt($this->report, $decorator);
    }

    public function executeSearch($request)
    {
        $this->search_form = new SearchReportForm();
        $this->search_form->bind($request->getParameter('searchreport'));
    }

}
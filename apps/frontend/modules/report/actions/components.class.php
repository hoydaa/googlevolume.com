<?php

class reportComponents extends sfComponents
{
    public function executeChart($request)
    {
        $decorator = new DefaultChartDecorator();
        $end_date = date('Y-m-d', strtotime($this->end_date . ' +1 days'));
        $this->line_chart = ReportPeer::getReportChart($this->report, $this->start_date, $end_date, $this->frequency, $decorator);
    }

    public function executeMiniChart($request)
    {
        $start_date = date('Y-m-d', strtotime(date('Ymd') . ' -12 days'));
        $end_date  = date('Y-m-d', strtotime(date('Ymd') . ' +1 days'));
        $frequency = QueryResultPeer::FREQUENCY_DAY;

        $x_labels = array($start_date, $end_date);
        $decorator = new ThumbnailChartDecorator($x_labels);

        $this->chart = ReportPeer::getReportChart($this->report, $start_date, $end_date, $frequency, $decorator);
    }

    public function executeSearch($request)
    {
        $this->search_form = new SearchReportForm();
        $this->search_form->bind($request->getParameter('searchreport'));
    }
        
}
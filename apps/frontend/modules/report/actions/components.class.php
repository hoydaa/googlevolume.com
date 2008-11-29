<?php

class reportComponents extends sfComponents
{

    public function executeChart($request)
    {
        $this->line_chart = ReportPeer::getReportChart($this->report, $this->start_date, $this->end_date, $this->frequency);
    }
    
    public function executeMiniChart($request)
    {
        $start_date = date('Y-m-d', strtotime(date('Ymd') . ' -12 days'));
        $end_date  = date('Y-m-d');
        $frequency = QueryResultPeer::FREQUENCY_DAY;

        $x_labels = array($start_date, $end_date);
        $decorator = new ThumbnailChartDecorator($x_labels);

        $this->chart = ReportPeer::getReportChart($this->report, $start_date, $end_date, $frequency, $decorator);
    }

}
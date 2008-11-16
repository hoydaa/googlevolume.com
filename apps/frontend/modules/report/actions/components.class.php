<?php

class reportComponents extends sfComponents
{

  public function executeChart($request)
  {
	$this->line_chart = ReportPeer::getReportChart($this->report, $this->start_date, $this->end_date, $this->frequency);
  }

}
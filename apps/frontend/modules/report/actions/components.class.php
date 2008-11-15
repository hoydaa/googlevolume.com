<?php

class reportComponents extends sfComponents
{

  public function executeChart($request)
  {
	$this->line_chart = Utils::get_report_chart($this->report, $this->start_date, $this->end_date, $this->frequency);
  }

}
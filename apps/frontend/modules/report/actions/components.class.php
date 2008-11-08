<?php

class reportComponents extends sfComponents
{

  public function executeChart($request)
  {
    //echo date('Y-m-d', mktime(1, 0, 0, date('m'), date('d')-date('w'), date('Y'))) . "<br/>";
  
    $this->line_chart = new LineChart();
    $this->line_chart->setTitle($this->report->getTitle());

    $series = new Series();
    $series->setXLabels(array('hede', 'podo'));
    $series->setYLabels(array('Armut', 'Elma'));
    
    $temp = array();
    $titles = array();
    foreach($this->report->getReportQuerys() as $report_query)
    {
      $arr = QueryResultPeer::retrieveByQueryIdDateRange(
        $report_query->getQueryId(), QueryResultPeer::FREQUENCY_DAY, $this->start_date, $this->end_date);
      $temp[] = $arr;
      $titles[] = $report_query->getTitle();
    }
    //$arrays = Utils::mergeArrays($temp);
    $arrays = Utils::other($temp);

    //echo "<pre>";
    //print_r(Utils::other($arrays));
    //print_r($arrays);
    //echo "</pre>";

    for($i = 0; $i < sizeof($arrays); $i++)
    {
      $series->addSerie(new Serie(Utils::arrayValues($arrays[$i]), $titles[$i]));
    }
    //$series->setMarkersEnabled(false);
    $series->normalize();
    $series->autoSetYLabels(5);

    $this->line_chart->setSeries($series);
  }

}
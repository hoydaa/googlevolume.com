<?php

class reportComponents extends sfComponents
{

  public function executeChart($request)
  {
  
    $this->line_chart = new LineChart();
    $this->line_chart->setTitle($this->report->getTitle());

    $series = new Series();
    $series->setXLabels(array('hede', 'hodo', 'pede', 'podo'));
    $series->setYLabels(array('Armut', 'Elma'));
    //$series->addSerie(new Serie(array(110, 20, 30, 40), 'deneme'));
    //$series->addSerie(new Serie(array(150, 50, 30, 10), 'deneme2'));
    //$series->addSerie(new Serie(array(5, 6, 100, 17), 'umut utkan'));
    //$series->normalize();
    //$series->autoSetYLabels();
    
    $temp = array();
    $titles = array();
    foreach($this->report->getReportQuerys() as $report_query)
    {
      $arr = QueryResultPeer::retrieveByQueryIdDateRange(
        $report_query->getQueryId(), QueryResultPeer::FREQUENCY_DAY);
      $temp[] = $arr;
      $titles[] = $report_query->getTitle();
    }
    $arrays = Utils::mergeArrays($temp);
    for($i = 0; $i < sizeof($arrays); $i++)
    {
      $series->addSerie(new Serie(Utils::arrayValues($arrays[$i]), $titles[$i]));
    }
    
    $series->normalize();
    $series->autoSetYLabels(5);

    $this->line_chart->setSeries($series);
  }

}
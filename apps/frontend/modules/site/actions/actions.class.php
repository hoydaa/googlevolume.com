<?php

/**
 * site actions.
 *
 * @package    project-y
 * @subpackage site
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class siteActions extends sfActions
{
  public function executeIndex($request)
  {
    $c = new Criteria();
    $c->setLimit(9);
    $reports = ReportPeer::doSelect($c);
    
    $start_date = date('Y-m-d', strtotime(date('Ymd') . ' -12 days'));
    $end_date  = date('Y-m-d');
    $frequency = QueryResultPeer::FREQUENCY_DAY;
    
    $x_labels = array($start_date, $end_date);
    $charts = array();
    $serie_labels = array();
    foreach($reports as $report)
    {
      $chart = Utils::get_report_chart($report, $start_date, $end_date, $frequency);
      $chart->setWidth(300);
      $chart->setHeight(150);
      $chart->getSeries()->setXLabels($x_labels);
      $chart->getSeries()->autoSetYLabels(2);
      $chart->getSeries()->setSerieLabelsEnabled(false);
      $chart->setTitle(null);
      //$chart->setTitleFont(11);
      
      $serie_label = array();
      foreach($chart->getSeries()->getSeries() as $serie)
      {
        $serie_label[] = array('color' => '#' . $serie->getColor(), 'title' => $serie->getLabel());
      }
      $serie_labels[] = $serie_label;
      
      $charts[] = $chart;
    }
    
    $this->charts = $charts;
    $this->reports = $reports;
    $this->serie_labels = $serie_labels;
  }

  public function executeMessage()
  {
  }
}

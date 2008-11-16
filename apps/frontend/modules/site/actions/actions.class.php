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
      $chart = ReportPeer::getReportChart($report, $start_date, $end_date, $frequency);
      $decorator = new ThumbnailChartDecorator($x_labels);
      $decorator->decorate($chart);
      
      $charts[] = $chart;
    }
    
    $this->charts = $charts;
    $this->reports = $reports;
  }

  public function executeMessage()
  {
  }
}

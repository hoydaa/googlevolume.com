<?php

class reportComponents extends sfComponents
{

  public function executeChart($request)
  {
  
    $this->line_chart = new LineChart();
    $this->line_chart->setTitle($this->report->getTitle());
    $this->line_chart->addSerie(new Serie(array(10, 20, 30, 40), 'deneme'));
  
  }

}
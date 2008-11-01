<?php

class reportComponents extends sfComponents
{

  public function executeChart($request)
  {
  
    $this->line_chart = new LineChart();
    $this->line_chart->setTitle($this->report->getTitle());

    $series = new Series();
    $series->setXLabels(array(1, 2, 3, 4));
    $series->setYLabels(array('Armut', 'Elma'));
    $series->addSerie(new Serie(array(110, 20, 30, 40), 'deneme'));
    $series->addSerie(new Serie(array(150, 50, 30, 10), 'deneme2'));
    $series->addSerie(new Serie(array(5, 6, 100, 17), 'umut utkan'));
    $series->normalize();
    $series->autoSetYLabels();

    $this->line_chart->setSeries($series);
  }

}
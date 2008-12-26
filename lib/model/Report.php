<?php

/**
 * Subclass for representing a row from the 'projecty_report' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Report extends BaseReport
{

  public function getTag()
  {
    $tag_names = array();
    $tags = $this->getReportTags();

    foreach($tags as $tag)
    {
      $tag_names[] = $tag->getName();
    }

    return implode(', ', $tag_names);
  }
  
  public function getQueryTitles()
  {
    $titles = array();
    foreach($this->getReportQuerys() as $report_query)
    {
      $titles[] = $report_query->getTitle();
    }
    return $titles;
  }
  
  public function incrementCounter()
  {
      $this->setViewCount($this->getViewCount() + 1);
      
  }
  
  public function decrementCounter()
  {
      $this->setViewCount($this->getViewCount() < 1 ? 0 : ($this->getViewCount() - 1));
  }

}

sfPropelBehavior::add('Report',
  array(
    'sfPropelFriendlyUrlBehavior' => array(
      'source_column' => 'title',
      'target_column' => 'stripped_title'
    )
  )
);

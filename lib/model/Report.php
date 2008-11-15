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

}

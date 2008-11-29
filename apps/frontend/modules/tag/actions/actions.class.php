<?php

/**
 * tag actions.
 *
 * @package    project-y
 * @subpackage tag
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class tagActions extends sfActions
{
  public function executeAutocomplete($request)
  {
    $tag = $request->getParameter('report[tags]');

    $this->tags = ReportTagPeer::getTagsByName($tag);
  }

  public function executeList()
  {
    $this->tags = ReportTagPeer::getPopularTags(100);
  }

  public function executeShow($request)
  {
    $this->pager = ReportPeer::findByTag($request->getParameter('tag'), $request->getParameter('page', 1), 10);
  }
}

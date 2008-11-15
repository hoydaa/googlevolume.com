<?php

/**
 * Subclass for performing query and update operations on the 'projecty_report' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ReportPeer extends BaseReportPeer
{
  public static function search($query, $page, $size)
  {
    $keywords = split(' ', trim($query));

    $c = new Criteria();

    foreach ($keywords as $keyword)
    {
      if (isset($criterion))
      {
        $criterion->addOr($c->getNewCriterion(ReportPeer::TITLE, '%' . $keyword . '%', Criteria::LIKE));
        $criterion->addOr($c->getNewCriterion(ReportPeer::DESCRIPTION, '%' . $keyword . '%', Criteria::LIKE));
      }
      else
      {
        $criterion = $c->getNewCriterion(ReportPeer::TITLE, '%' . $keyword . '%', Criteria::LIKE);
        $criterion->addOr($c->getNewCriterion(ReportPeer::DESCRIPTION, '%' . $keyword . '%', Criteria::LIKE));
      }
    }

    $c->add($criterion);

    $pager = new sfPropelPager('Report', $size);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  public static function findByTag($tag, $page, $size)
  {
    $c = new Criteria();
    $c->addJoin(self::ID, ReportTagPeer::REPORT_ID, Criteria::LEFT_JOIN);
    $c->add($c->getNewCriterion(ReportTagPeer::NAME, $tag));
    $c->setDistinct();

    $pager = new sfPropelPager('Report', $size);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }
}

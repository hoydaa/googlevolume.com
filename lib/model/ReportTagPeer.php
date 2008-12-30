<?php

/**
 * Subclass for performing query and update operations on the 'projecty_report_tag' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ReportTagPeer extends BaseReportTagPeer
{
  public static function getTagsByName($tag, $max = 10) 
  {
    $connection = Propel::getConnection();
  
    $query = "SELECT DISTINCT %s as tag FROM %s WHERE %s like '%s' ORDER BY %s ASC";
    $query = sprintf($query, ReportTagPeer::NAME, ReportTagPeer::TABLE_NAME, ReportTagPeer::NAME, 
        $tag.'%', ReportTagPeer::NAME, ReportTagPeer::NAME);
    
    $statement = $connection->prepareStatement($query);
    $statement->setLimit($max);
    
    $resultset = $statement->executeQuery();
    
    $tags = array();
    
    while($resultset->next())
    {
      $tags[] = $resultset->getString('tag');
    }
    
    return $tags;
  }

  public static function getPopularTags($max = 30)
  {
    $connection = Propel::getConnection();

    $query = 'SELECT %s as tag, COUNT(*) as count
              FROM %s
              INNER JOIN %s ON %s = %s
              GROUP BY tag
              ORDER BY count DESC';

    $query = sprintf($query,
      ReportTagPeer::NAME,
      ReportTagPeer::TABLE_NAME,
      ReportPeer::TABLE_NAME,
      ReportTagPeer::REPORT_ID,
      ReportPeer::ID
    );

    $statement = $connection->prepareStatement($query);
    $statement->setLimit($max);

    $resultset = $statement->executeQuery();

    $tags = array();

    $max_count = 0;

    while($resultset->next())
    {
      if (!$max_count)
      {
        $max_count = $resultset->getInt('count');
      }

      $tags[] = array(
        'tag' => $resultset->getString('tag'),
        'rank' => floor(($resultset->getInt('count') / $max_count * 9) + 1),
        'count' => $resultset->getInt('count')
      );
    }

    ksort($tags);

    return $tags;
  }
}

<?php

/**
 * Subclass for performing query and update operations on the 'projecty_report_tag' table.
 *
 * 
 *
 * @package lib.model
 */ 
class TagPeer extends BaseTagPeer
{

  public static function getTagsByName($tag, $max = 10) 
  {
    $connection = Propel::getConnection();
  
    $query = "SELECT DISTINCT %s as tag FROM %s WHERE %s like '%s' ORDER BY %s ASC";
    $query = sprintf($query, TagPeer::NAME, TagPeer::TABLE_NAME, TagPeer::NAME, 
        $tag.'%', TagPeer::NAME, TagPeer::NAME);
    
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

}

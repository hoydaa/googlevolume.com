<?php

/**
 * Subclass for performing query and update operations on the 'projecty_query_result' table.
 *
 * 
 *
 * @package lib.model
 */ 
class QueryResultPeer extends BaseQueryResultPeer
{

  const FREQUENCY_DAY   = 'DAY';
  const FREQUENCY_WEEK  = 'WEEK';
  const FREQUENCY_MONTH = 'MONTH';

  public static function retrieveByQueryIdDateRange($query_id, $frequency, $start_date, $end_date)
  {
    if($frequency == self::FREQUENCY_DAY)
    {
      $query = "SELECT %s as result_date, %s as result_size FROM %s WHERE %s >= '%s' AND %s <= '%s' AND %s = %s ORDER BY %s";
      $query = sprintf($query,
        QueryResultPeer::CREATED_AT,
        QueryResultPeer::RESULT_SIZE,
        QueryResultPeer::TABLE_NAME,
        QueryResultPeer::CREATED_AT,
        $start_date,
        QueryResultPeer::CREATED_AT,
        $end_date,
        QueryResultPeer::QUERY_ID,
        $query_id,
        QueryResultPeer::CREATED_AT
      );
    } else if($frequency == self::FREQUENCY_WEEK)
    {
      $query = "SELECT CONCAT(YEAR(%s), WEEK(%s)) as result_date, AVG(%s) as result_size FROM %s WHERE %s >= '%s' AND %s <= '%s' AND %s = %s GROUP BY WEEK(%s) ORDER BY %s";
      $query = sprintf($query,
        QueryResultPeer::CREATED_AT,
        QueryResultPeer::CREATED_AT,
        QueryResultPeer::RESULT_SIZE,
        QueryResultPeer::TABLE_NAME,
        QueryResultPeer::CREATED_AT,
        $start_date,
        QueryResultPeer::CREATED_AT,
        $end_date,
        QueryResultPeer::ID,
        $query_id,
        QueryResultPeer::CREATED_AT,
        QueryResultPeer::CREATED_AT
      );
    } else if($frequency == self::FREQUENCY_MONTH)
    {
      $query = "SELECT CONCAT(YEAR(%s), MONTH(%s)) as result_date, %s as result_size FROM %s WHERE %s >= '%s' AND %s <= '%s' AND %s = %s GROUP BY MONTH(%s) ORDER BY %s";
      $query = sprintf($query,
        QueryResultPeer::CREATED_AT,
        QueryResultPeer::CREATED_AT,
        QueryResultPeer::RESULT_SIZE,
        QueryResultPeer::TABLE_NAME,
        QueryResultPeer::CREATED_AT,
        $start_date,
        QueryResultPeer::CREATED_AT,
        $end_date,
        QueryResultPeer::ID,
        $query_id,
        QueryResultPeer::CREATED_AT,
        QueryResultPeer::CREATED_AT
      );
    } else 
    {
      return null;
    }
    $connection = Propel::getConnection();
    $statement = $connection->prepareStatement($query);
    $resultset = $statement->executeQuery();
    $rtn = array();
    while($resultset->next())
    {
      $rtn[$resultset->getString('result_date')] = $resultset->getString('result_size');
    }
    return $rtn;
  }

}

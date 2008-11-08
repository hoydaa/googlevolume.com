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
  public static $frequency_arr = array(self::FREQUENCY_DAY, self::FREQUENCY_WEEK, self::FREQUENCY_MONTH);

  public static function retrieveByQueryIdDateRange($query_id, $frequency, $start_date = null, $end_date = null)
  {
    if($frequency == self::FREQUENCY_DAY)
    {
      if($start_date && $end_date)
      {
        $query = "
          SELECT DATE(%s) as result_date, AVG(%s) as result_size 
          FROM %s 
          WHERE %s >= '%s' AND %s <= '%s' AND %s = %s 
          GROUP BY %s 
          ORDER BY %s";
      } else 
      {
        $query = "
          SELECT DATE(%s) as result_date, AVG(%s) as result_size
          FROM %s
          WHERE %s = %s 
          GROUP BY %s
          ORDER BY %s
          LIMIT 30";
      }
    } else if($frequency == self::FREQUENCY_WEEK)
    {
      if($start_date && $end_date)
      {
        $query = "
          SELECT CONCAT(YEAR(%s), WEEK(%s)) as result_date, AVG(%s) as result_size 
          FROM %s 
          WHERE %s >= '%s' AND %s <= '%s' AND %s = %s 
          GROUP BY WEEK(%s) 
          ORDER BY %s";
      } else
      {
        $query = "
          SELECT CONCAT(YEAR(%s), WEEK(%s)) as result_date, AVG(%s) as result_size
          FROM %s
          WHERE %s = %s 
          GROUP BY WEEK(%s)
          ORDER BY %s
          LIMIT 100";
      }
    } else if($frequency == self::FREQUENCY_MONTH)
    {
      if($start_date && $end_date)
      {
        $query = "
          SELECT CONCAT(YEAR(%s), MONTH(%s)) as result_date, %s as result_size 
          FROM %s 
          WHERE %s >= '%s' AND %s <= '%s' AND %s = %s 
          GROUP BY MONTH(%s) 
          ORDER BY %s";
      } else
      {
        $query = "
          SELECT CONCAT(YEAR(%s), MONTH(%s)) as result_date, %s as result_size
          FROM %s
          WHERE %s = %s 
          GROUP BY MONTH(%s)
          ORDER BY %s
          LIMIT 100";
      }
    } else 
    {
      return null;
    }
    
    if($start_date && $end_date)
    {
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
        QueryResultPeer::CREATED_AT,
        QueryResultPeer::CREATED_AT
      );
    } else
    {
      $query = sprintf($query,
        QueryResultPeer::CREATED_AT,
        QueryResultPeer::RESULT_SIZE,
        QueryResultPeer::TABLE_NAME,
        QueryResultPeer::QUERY_ID,
        $query_id,
        QueryResultPeer::CREATED_AT,
        QueryResultPeer::CREATED_AT
      );
    }
    
    $connection = Propel::getConnection();
    $statement = $connection->prepareStatement($query);
    $resultset = $statement->executeQuery();
    $rtn = array();
    while($resultset->next())
    {
      $rtn[$resultset->getString('result_date')] = ((int)$resultset->getString('result_size'));
    }
    return $rtn;
  }

}

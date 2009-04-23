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
    
    public static function countDaily($query_id) {
        $query = "
        	SELECT COUNT(*) as cnt
        	FROM %s
        	WHERE %s = %s";
        
        $query = sprintf($query,
        QueryResultPeer::TABLE_NAME,
        QueryResultPeer::QUERY_ID,
        $query_id);
        
        $resultset = self::_execute($query);
        $resultset->next();
        
        return $resultset->getInt('cnt');
    }
    
    public static function countWeekly($query_id) {
        $query = "
        	SELECT COUNT(*) as cnt FROM (
        	SELECT DISTINCT CONCAT(YEAR(%s), (WEEK(%s) + 1)) FROM %s
        	WHERE %s = %s) as bidi";
        
        $query = sprintf($query,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::TABLE_NAME,
        QueryResultPeer::QUERY_ID,
        $query_id
        );
        
        $resultset = self::_execute($query);
        $resultset->next();
        
        return $resultset->getInt('cnt');
    }
    
    public static function countMonthly($query_id) {
        $query = "
        	SELECT COUNT(*) as cnt FROM (
        	SELECT DISTINCT CONCAT(YEAR(%s), MONTH(%s))
        	FROM %s
        	WHERE %s = %s) as bidi";
        
        $query = sprintf($query,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::TABLE_NAME,
        QueryResultPeer::QUERY_ID,
        $query_id
        );
        
        $resultset = self::_execute($query);
        $resultset->next();
        
        return $resultset->getInt('cnt');
    }
    
    public static function getChartData($query_id, $frequency, $start_date, $end_date)
    {
        if($frequency == QueryResultPeer::FREQUENCY_MONTH)
        {
            return QueryResultPeer::monthly($query_id, $start_date, $end_date);
        } else if($frequency == QueryResultPeer::FREQUENCY_WEEK)
        {
            return QueryResultPeer::weekly($query_id, $start_date, $end_date);
        } else
        {
            return QueryResultPeer::daily($query_id, $start_date, $end_date);
        }
    }

    public static function daily($query_id, $start_date, $end_date)
    {
        $query = "
      		SELECT DATE(%s) as result_date, AVG(%s) as result_size 
      		FROM %s 
      		WHERE %s >= '%s' AND %s <= '%s' AND %s = %s 
      		GROUP BY %s 
      		ORDER BY %s";
        $query = sprintf($query,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::RESULT_SIZE,
        QueryResultPeer::TABLE_NAME,
        QueryResultPeer::RESULT_DATE,
        $start_date,
        QueryResultPeer::RESULT_DATE,
        $end_date,
        QueryResultPeer::QUERY_ID,
        $query_id,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::RESULT_DATE
        );

        return self::_execute_query($query);
    }

    public static function weekly($query_id, $start_date, $end_date)
    {
        $query = "
      		SELECT CONCAT(YEAR(%s), (WEEK(%s) + 1)) as result_date, AVG(%s) as result_size 
      		FROM %s 
      		WHERE %s >= '%s' AND %s <= '%s' AND %s = %s 
      		GROUP BY CONCAT(YEAR(%s), WEEK(%s)) 
      		ORDER BY %s";
        $query = sprintf($query,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::RESULT_SIZE,
        QueryResultPeer::TABLE_NAME,
        QueryResultPeer::RESULT_DATE,
        $start_date,
        QueryResultPeer::RESULT_DATE,
        $end_date,
        QueryResultPeer::QUERY_ID,
        $query_id,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::RESULT_DATE
        );

        $temp = self::_execute_query($query);
        $rtn = array();
        foreach($temp as $key => $value)
        {
            $rtn[Utils::get_date_of_first_day_in_a_week(substr($key, 4), substr($key, 0, 4))] = $value;
        }

        return $rtn;
    }

    public static function monthly($query_id, $start_date, $end_date)
    {
        $query = "
      		SELECT CONCAT(YEAR(%s), MONTH(%s)) as result_date, %s as result_size 
      		FROM %s 
      		WHERE %s >= '%s' AND %s <= '%s' AND %s = %s 
      		GROUP BY CONCAT(YEAR(%s), MONTH(%s))
      		ORDER BY %s";
        $query = sprintf($query,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::RESULT_SIZE,
        QueryResultPeer::TABLE_NAME,
        QueryResultPeer::RESULT_DATE,
        $start_date,
        QueryResultPeer::RESULT_DATE,
        $end_date,
        QueryResultPeer::QUERY_ID,
        $query_id,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::RESULT_DATE,
        QueryResultPeer::RESULT_DATE
        );

        $temp = self::_execute_query($query);
        $rtn = array();
        foreach($temp as $key => $value)
        {
            $month = substr($key, 4);
            $month = strlen($month) == 1 ? '0' . $month : $month;
            $rtn[date('Y-m-d', strtotime(substr($key, 0, 4) . $month . '01'))] = $value;
        }

        return $rtn;
    }

    private static function _execute_query($query)
    {
        $resultset = self::_execute($query);

        $rtn = array();
        while($resultset->next())
        {
            $rtn[$resultset->getString('result_date')] = $resultset->getString('result_size');
        }
        
        return $rtn;
    }
    
    private static function _execute($query) {
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        return $statement->executeQuery();
    }
}

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

    public static function search($query, $user_id, $source, $page, $size)
    {
        $keywords = split(' ', trim($query));

        $c = new Criteria();

        if ($user_id)
        {
            if ($source == 'U')
            {
                $c->add(ReportPeer::USER_ID, $user_id);
            }
            else
            {
                $source_criterion = $c->getNewCriterion(ReportPeer::USER_ID, $user_id);
                $source_criterion->addOr($c->getNewCriterion(ReportPeer::PUBLIC_RECORD, true));
                $c->add($source_criterion);
            }
        }
        else
        {
            $c->add(ReportPeer::PUBLIC_RECORD, true);
        }

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
    
    public static function findByQuery($query, $page, $size)
    {
        $c = new Criteria();
        $c->addJoin(ReportPeer::ID, ReportQueryPeer::REPORT_ID);
        $c->addJoin(ReportQueryPeer::QUERY_ID, QueryPeer::ID);
        $c->add(QueryPeer::QUERY, $query);
        $c->setDistinct();

        $pager = new sfPropelPager('Report', $size);
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();

        return $pager;
    }

    public static function countUserReports($userId)
    {
        $c = new Criteria();
        $c->add(ReportPeer::USER_ID, $userId);

        return ReportPeer::doCount($c);
    }

    public static function countPublicUserReports($userId)
    {
        $c = new Criteria();
        $c->add(ReportPeer::USER_ID, $userId);
        $c->add(ReportPeer::PUBLIC_RECORD, true);

        return ReportPeer::doCount($c);
    }

    public static function findByUser($userId, $page, $size)
    {
        $c = new Criteria();
        $c->add(ReportPeer::USER_ID, $userId);
        $c->addDescendingOrderByColumn(ReportPeer::CREATED_AT);

        $pager = new sfPropelPager('Report', $size);
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();

        return $pager;
    }

    public static function findByUserAndPublic($user_id, $public, $page, $size)
    {
        $c = new Criteria();
        $c->add(ReportPeer::USER_ID, $user_id);
        $c->add(ReportPeer::PUBLIC_RECORD, $public);
        $c->addDescendingOrderByColumn(ReportPeer::CREATED_AT);

        $pager = new sfPropelPager('Report', $size);
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();

        return $pager;
    }
    
    public static function findByPopularity($page, $size, $order = 'desc')
    {
        $c = new Criteria();
        $c->add(ReportPeer::PUBLIC_RECORD, true);
        if($order == 'desc')
        {
            $c->addDescendingOrderByColumn(ReportPeer::VIEW_COUNT);
        } else
        {
            $c->addAscendingOrderByColumn(ReportPeer::VIEW_COUNT);
        }
        
        $pager = new sfPropelPager('Report', $size);
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();
        
        return $pager;
    }

    public static function findByStability($page, $size, $order = 'asc')
    {
        $sql = "(SELECT AVG(%s) FROM %s INNER JOIN %s On %s=%s WHERE %s=%s GROUP BY %s)";
        $sql = sprintf($sql, 
            QueryPeer::STANDARD_DEVIATION, 
            QueryPeer::TABLE_NAME, 
            ReportQueryPeer::TABLE_NAME, 
            QueryPeer::ID,
            ReportQueryPeer::QUERY_ID,
            ReportQueryPeer::REPORT_ID,
            ReportPeer::ID,
            ReportPeer::ID);
        $c = new Criteria();
        $c->addAsColumn('stability', $sql);
        $c->add(ReportPeer::PUBLIC_RECORD, true);
        if($order == 'asc')
        {
            $c->addAscendingOrderByColumn('stability');
        } else
        {
            $c->addDescendingOrderByColumn('stability');
        }
        
        $pager = new sfPropelPager('Report', $size);
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();
        
        return $pager;
    }
    
    public static function findByAmount($page, $size, $order = 'desc')
    {
        $sql = "(SELECT COUNT(%s) FROM %s INNER JOIN %s On %s=%s INNER JOIN %s ON %s=%s WHERE %s=%s GROUP BY %s)";
        $sql = sprintf($sql, 
            QueryPeer::STANDARD_DEVIATION, 
            QueryPeer::TABLE_NAME, 
            ReportQueryPeer::TABLE_NAME, 
            QueryPeer::ID, 
            ReportQueryPeer::QUERY_ID,
            QueryResultPeer::TABLE_NAME,
            ReportQueryPeer::QUERY_ID,
            QueryResultPeer::QUERY_ID,
            ReportQueryPeer::REPORT_ID,
            ReportPeer::ID,
            ReportPeer::ID);
        $c = new Criteria();
        $c->addAsColumn('result_count', $sql);
        $c->add(ReportPeer::PUBLIC_RECORD, true);
        if($order == 'asc')
        {
            $c->addAscendingOrderByColumn('result_count');
        } else
        {
            $c->addDescendingOrderByColumn('result_count');
        }
        
        $pager = new sfPropelPager('Report', $size);
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();
        
        return $pager;
    }
    
    public static function findNewReports($page, $size, $order = 'desc')
    {
        $c = new Criteria();
        $c->add(ReportPeer::PUBLIC_RECORD, true);
        if($order == 'desc')
        {
            $c->addDescendingOrderByColumn(ReportPeer::CREATED_AT);
        } else {
            $c->addAscendingOrderByColumn(ReportPeer::CREATED_AT);
        }
        
        $pager = new sfPropelPager('Report', $size);
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();
        
        return $pager;
    }
    
    public static function getMeasurementInterval($report_id) {
        $first_date = self::getFirstMeasurementDate($report_id);
        $last_date  = self::getLastMeasurementDate($report_id);
        if($first_date == $last_date) {
            $last_date = date('Y-m-d', strtotime('+1 day', strtotime($last_date)));
            $first_date = date('Y-m-d', strtotime('-1 day', strtotime($first_date)));
        }
        
        $rtn = array('first' => $first_date, 'last' => $last_date);
        
        return $rtn;
    }
    
    public static function getFirstMeasurementDate($report_id) {
        $query = "
        	SELECT MIN(%s) as first
        	FROM %s
        	INNER JOIN %s ON %s = %s
        	INNER JOIN %s ON %s = %s
        	WHERE %s = %s";
        
        $query = sprintf($query,
            QueryResultPeer::RESULT_DATE,
            QueryResultPeer::TABLE_NAME,
            QueryPeer::TABLE_NAME,
            QueryResultPeer::QUERY_ID,
            QueryPeer::ID,
            ReportQueryPeer::TABLE_NAME,
            ReportQueryPeer::QUERY_ID,
            QueryPeer::ID,
            ReportQueryPeer::REPORT_ID,
            $report_id);
            
        $resultset = self::_execute($query);
        $resultset->next();
        
        return $resultset->getString('first');
    }
    
    public static function getLastMeasurementDate($report_id) {
        $query = "
        	SELECT MAX(%s) as last
        	FROM %s
        	INNER JOIN %s ON %s = %s
        	INNER JOIN %s ON %s = %s
        	WHERE %s = %s";
        
        $query = sprintf($query,
            QueryResultPeer::RESULT_DATE,
            QueryResultPeer::TABLE_NAME,
            QueryPeer::TABLE_NAME,
            QueryResultPeer::QUERY_ID,
            QueryPeer::ID,
            ReportQueryPeer::TABLE_NAME,
            ReportQueryPeer::QUERY_ID,
            QueryPeer::ID,
            ReportQueryPeer::REPORT_ID,
            $report_id);
            
        $resultset = self::_execute($query);
        $resultset->next();
        
        return $resultset->getString('last');
    }
    
    public static function getReportChartt($report, $decorator = null) {
        $rtn = self::_getReportChartt($report, $decorator);
        if($rtn == null)
        {
            return null;
        }
        return $rtn['chart'];
    }
    
    const DAY_COUNT   = 21;
    const WEEK_COUNT  = 21;
    const MONTH_COUNT = 21;
    public static function _getReportChartt($report, $decorator = null) {
        $interval = self::getMeasurementInterval($report->getId());
        // fetch the date of the first measurement
        $start_date = $interval['first'];
        // fetch the date of the last measurement
        $end_date = $interval['last'];
        // number of daily measurements
        $day_count = 0;
        // number of weekly measurements
        $week_count = 0;
        // number of monthly measurements
        $month_count = 0;
        
        foreach($report->getReportQuerys() as $report_query) {
            sfContext::getInstance()->getLogger()->info("ARMUT ARMUT ARMUT");
            
            $temp = QueryResultPeer::countDaily($report_query->getQueryId());
            if($temp > $day_count) {
                $day_count = $temp;
            }
            $temp = QueryResultPeer::countWeekly($report_query->getQueryId());
            if($temp > $week_count) {
                $week_count = $temp;
            }
            $temp = QueryResultPeer::countMonthly($report_query->getQueryId());
            if($temp > $month_count) {
                $month_count = $temp;
            }
        }
        
        sfContext::getInstance()->getLogger()->info("$day_count $week_count $month_count");
        
        if($day_count <= self::DAY_COUNT) {
            $decorator->setFrequency('D');
            return self::_getReportChart($report, $start_date, $end_date, QueryResultPeer::FREQUENCY_DAY, $decorator);
        } else if($week_count <= self::WEEK_COUNT) {
            $decorator->setFrequency('W');
            return self::_getReportChart($report, $start_date, $end_date, QueryResultPeer::FREQUENCY_WEEK, $decorator);
        } else {
            $decorator->setFrequency('M');
            return self::_getReportChart($report, $start_date, $end_date, QueryResultPeer::FREQUENCY_MONTH, $decorator);
        }
    }
    
    public static function getReportChart($report, $start_date, $end_date, $frequency, $decorator = null)
    {
        $rtn = self::_getReportChart($report, $start_date, $end_date, $frequency, $decorator);
        if($rtn == null)
        {
            return null;
        }
        return $rtn['chart'];
    }
    
    public static function _getReportChart($report, $start_date, $end_date, $frequency, $decorator = null)
    {
        $line_chart = new LineChart();
        $line_chart->setTitle($report->getTitle());

        $series = new Series();

        $temp = ReportPeer::getQueryResults($report->getId(), $start_date, $end_date, $frequency);
        if(self::isEmpty($temp))
        {
            return null;
        }
        
        $titles = $report->getQueryTitles();
        $arrays = ReportPeer::fillWithEmptyValues($temp, $start_date, $end_date, $frequency);
        
        for($i = 0; $i < sizeof($arrays); $i++)
        {
            $series->addSerie(new Serie(array_values($arrays[$i]), $titles[$i]));
        }
        
        $factors = Utils::find_factors(sizeof($arrays[0]) - 1, 7);
        $factor = $factors[sizeof($factors) - 1];
        $labels = array();
        for($j = 0; $j < $factor + 1; $j++)
        {
            $labels[] = ($j + 1);
        }
        $temp = array_keys($arrays[0]);
        for($j = 0; $j < sizeof($labels); $j++)
        {
            if($frequency == QueryResultPeer::FREQUENCY_MONTH)
            {
                $labels[$j] = date('M y', strtotime($temp[$j * (sizeof($arrays[0]) - 1) / $factor]));
            } else {
                $labels[$j] = $temp[$j * (sizeof($arrays[0]) - 1) / $factor];
            }
        }
        $series->setXLabels($labels);

        $series->autoSetYLabels(5);
        $series->normalize();

        $line_chart->setSeries($series);

        if($decorator)
        {
            $decorator->decorate($line_chart);
        }
        
        return array('values' => $arrays, 'chart' => $line_chart);
    }

    private static function getQueryResults($report_id, $start_date, $end_date, $frequency = QueryResultPeer::FREQUENCY_DAY)
    {
        $report = ReportPeer::retrieveByPK($report_id);
        $temp = array();
        foreach($report->getReportQuerys() as $report_query)
        {
            $arr = QueryResultPeer::getChartData($report_query->getQueryId(), $frequency, $start_date, $end_date);
            $temp[] = $arr;
        }

        return $temp;
    }

    // fills missing dates with empty values which is by default -1
    private static function fillWithEmptyValues($arrays, $start_date, $end_date, $frequency = QueryResultPeer::FREQUENCY_DAY)
    {
        $min_date = strtotime($start_date);
        $max_date = strtotime($end_date);

        $rtn = array();

        if($frequency == QueryResultPeer::FREQUENCY_WEEK)
        {
            $counter = 0;
            foreach($arrays as $array)
            {
                $min_custom = strtotime(Utils::get_date_of_first_day_in_a_week(date('W', $min_date), date('o', $min_date)));
                $max_custom = strtotime(Utils::get_date_of_first_day_in_a_week(date('W', $max_date), date('o', $max_date)));
                $weeks = ceil((($max_date - $min_date) / 24 / 60 / 60 / 7));

                $rtn[] = array();
//                for($i = 0; $i < $weeks; $i++)
//                {
                while($min_custom <= $max_custom) {
                    if(array_key_exists(date('Y-m-d', $min_custom), $array))
                    {
                        //$rtn[$counter][date('Y-m-d', $min_custom)] = $array[date('Y-m-d', $min_custom)];
                        $rtn[$counter][date('o', $min_custom) . '-' . date('W', $min_custom)] = $array[date('Y-m-d', $min_custom)];
                    } else
                    {
                        //$rtn[$counter][date('Y-m-d', $min_custom)] = -1;
                        $rtn[$counter][date('o', $min_custom) . '-' . date('W', $min_custom)] = -1;
                    }
                    $min_custom = strtotime(date('Y-m-d', $min_custom) .' +1 weeks');
                }
                $counter++;
            }
        } else if($frequency == QueryResultPeer::FREQUENCY_MONTH)
        {
            $min_custom = strtotime(date('Y', $min_date) . date('m', $min_date) . '01');
            $months = (date('Y', $max_date) - date('Y', $min_date)) * 12 + date('m', $max_date) - date('m', $min_date);
            $counter = 0;
            foreach($arrays as $array)
            {
                $rtn[] = array();
                for($i = 0; $i < $months + 1; $i++)
                {
                    $date_temp = strtotime(date('Y-m-d', $min_custom) . ' +' .$i. ' months');
                    if(array_key_exists(date('Y-m-d', $date_temp), $array))
                    {
                        $rtn[$counter][date('Y-m-d', $date_temp)] = $array[date('Y-m-d', $date_temp)];
                    } else
                    {
                        $rtn[$counter][date('Y-m-d', $date_temp)] = -1;
                    }
                }
                $counter++;
            }
        } else
        {
            $days = ceil((($max_date - $min_date) / 24 / 60 / 60)) + 1;

            $counter = 0;
            foreach($arrays as $array)
            {
                $rtn[] = array();
//                for($i = 0; $i < $days; $i++)
                $date_temp = $min_date;
                while($date_temp <= $max_date)
                {
                    if(array_key_exists(date('Y-m-d', $date_temp), $array))
                    {
                        $rtn[$counter][date('Y-m-d', $date_temp)] = $array[date('Y-m-d', $date_temp)];
                    } else
                    {
                        $rtn[$counter][date('Y-m-d', $date_temp)] = -1;
                    }
                    $date_temp = strtotime('+1 day', $date_temp);
                }
                $counter++;
            }
        }

        return $rtn;
    }
    
    private static function isEmpty($array)
    {
        foreach($array as $inner_array)
        {
            if($inner_array)
            {
                return false;
            }
        }
        return true;
    }
    
    private static function _execute($query) {
        $connection = Propel::getConnection();
        $statement = $connection->prepareStatement($query);
        return $statement->executeQuery();
    }

}

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

    public static function countUserReports($userId)
    {
        $c = new Criteria();
        $c->add(ReportPeer::USER_ID, $userId);

        return ReportPeer::doCount($c);
    }

    public static function findByUser($userId, $page, $size)
    {
        $c = new Criteria();
        $c->add(ReportPeer::USER_ID, $userId);

        $pager = new sfPropelPager('Report', $size);
        $pager->setCriteria($c);
        $pager->setPage($page);
        $pager->init();

        return $pager;
    }
    
    /**
     * TODO: Will be improved
     *
     * @param unknown_type $max
     * @return unknown
     */
    public static function findByPopularity($max = 10)
    {
        $c = new Criteria();
        $c->setLimit($max);
        return ReportPeer::doSelect($c);
    }

    public static function getReportChart($report, $start_date, $end_date, $frequency, $decorator = null)
    {    
        $line_chart = new LineChart();
        $line_chart->setTitle($report->getTitle());

        $series = new Series();

        $temp = ReportPeer::getQueryResults($report->getId(), $start_date, $end_date, $frequency);
        $titles = $report->getQueryTitles();
        $arrays = ReportPeer::fillWithEmptyValues($temp, $start_date, $end_date, $frequency);

        for($i = 0; $i < sizeof($arrays); $i++)
        {
            $series->addSerie(new Serie(array_values($arrays[$i]), $titles[$i]));
        }

        $factors = Utils::find_factors(sizeof($arrays[0]) - 1, 10);
        if($frequency == QueryResultPeer::FREQUENCY_WEEK)
        {
            $factor = $factors[sizeof($factors) - 1];
            $labels = array();
            for($j = 0; $j < $factor + 1; $j++)
            {
                $labels[] = ($j + 1);
            }
            $temp = array_keys($arrays[0]);
            for($j = 0; $j < sizeof($labels); $j++)
            {
                $labels[$j] = $temp[$j];
            }
            $series->setXLabels($labels);
        } else if($frequency == QueryResultPeer::FREQUENCY_MONTH)
        {
            $series->setXLabels(Utils::date_array_to_format(array_keys($arrays[0]), 'M y'));
        } else
        {
            $factors = Utils::find_factors(sizeof($arrays[0]) - 1, 10);
            $factor = $factors[sizeof($factors) - 1];
            $labels = array();
            for($j = 0; $j < $factor + 1; $j++)
            {
                $labels[] = ($j + 1);
            }
            $temp = array_keys($arrays[0]);
            for($j = 0; $j < sizeof($labels); $j++)
            {
                $labels[$j] = $temp[$j];
            }
            $series->setXLabels($labels);
        }

        $series->autoSetYLabels(5);
        $series->normalize();

        $line_chart->setSeries($series);

        if($decorator)
        {
            $decorator->decorate($line_chart);
        }

        return $line_chart;
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
                $min_custom = strtotime(Utils::get_date_of_first_day_in_a_week(date('W', $min_date), date('Y', $min_date)));
                $max_custom = strtotime(Utils::get_date_of_first_day_in_a_week(date('W', $max_date), date('Y', $max_date)));
                $weeks = ceil((($max_date - $min_date) / 24 / 60 / 60 / 7));

                $rtn[] = array();
                for($i = 0; $i < $weeks; $i++)
                {
                    $min_custom = strtotime(date('Y-m-d', $min_custom) .' +1 weeks');
                    if(array_key_exists(date('Y-m-d', $min_custom), $array))
                    {
                        $rtn[$counter][date('Y-m-d', $min_custom)] = $array[date('Y-m-d', $min_custom)];
                    } else
                    {
                        $rtn[$counter][date('Y-m-d', $min_custom)] = -1;
                    }
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
            $days = ceil((($max_date - $min_date) / 24 / 60 / 60));

            $counter = 0;
            foreach($arrays as $array)
            {
                $rtn[] = array();
                for($i = 0; $i < $days; $i++)
                {
                    $date_temp = strtotime('+'.$i.' day', $min_date);
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
        }

        return $rtn;
    }

}

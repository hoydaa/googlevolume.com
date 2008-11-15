<?php

class Utils
{ 
  public static function other($arrays, $start_date, $end_date, $frequency = QueryResultPeer::FREQUENCY_DAY)
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

  public static function years_array()
  {
    $end = date('Y');
    $start = $end - 100;

    $years = range($start, $end);

    return array_combine($years, $years);
  }

  public static function date($date)
  {
    $year = $date['year'];
    $month = $date['month'];
    $day = $date['day'];

    if ($year == '' || $month == '' && $day == '')
    {
      return null;
    }

    return $year . '-' . $month . '-' . $day;
  }
  
  public static function get_date_of_first_day_in_a_week($week_number, $year) {
    $time = strtotime($year . '0104 +' . ($week_number - 1) . ' weeks');
    $monday_time = strtotime('-' . (date('w', $time) - 1) . ' days', $time);
    return date('Y-m-d', $monday_time);
  }
  
  public static function date_array_to_format($array, $format)
  {
    $rtn = array();
    foreach($array as $item)
    {
      $rtn[] = date($format, strtotime($item));
    }
    return $rtn;
  }
  
  public static function find_maximum_decimal_factor($num)
  {
    $divider = 1;
    while($num / $divider > 100)
    {
      $divider *= 10;
    }
    return $divider;
  }
  
  public static function find_factors($num, $max = null)
  {
    $max = $max ? $max : $num / 2;
    $rtn = array();
    for($i = 1; $i <= $max; $i++)
    {
      $temp = $num / $i;
      if($temp - round($temp, 0) == 0)
      {
        $rtn[] = $i;
      }
    }
    return $rtn;
  }
  
  public static function get_report_chart($report, $start_date, $end_date, $frequency)
  {
    $line_chart = new LineChart();
    $line_chart->setTitle($report->getTitle());

    $series = new Series();
    
    $temp = ReportPeer::getQueryResults($report->getId(), $start_date, $end_date, $frequency);
    $titles = $report->getQueryTitles();
    $arrays = Utils::other($temp, $start_date, $end_date, $frequency);

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
    return $line_chart;
  }
  
  public static function isUserRecord($class_name, $record_id, $user_id) {
    $class = new ReflectionClass($class_name);
    $c = new Criteria();
    $c->add($class->getConstant('USER_ID'), $user_id);
    $c->add($class->getConstant('ID'), $record_id);
    $record = $class->getMethod('doSelectOne')->invoke(null, $c);
    return $record != null;
  }
  
}

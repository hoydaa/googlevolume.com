<?php

class Utils
{

  public static function mergeArrays($arrays)
  {
    $rtn = array();
    $counter = 0;
    foreach($arrays as $array)
    {
      $rtn[] = array();
    }
    
    $counter = 0;
    foreach($arrays as $array)
    {
      foreach($array as $key => $value)
      {
        $rtn[$counter][$key] = $value;
        for($i = 0; $i < sizeof($rtn); $i++)
        {
          if(!array_key_exists($key, $rtn[$i]))
          {
            $rtn[$i][$key] = -1;
          }
        }
      }
      $counter++;
    }
    
    return $rtn;
  }
  
  public static function arrayValues($array)
  {
    $rtn = array();
    foreach($array as $key => $value)
    {
      $rtn[] = $value; 
    }
    return $rtn;
  }
  
  public static function other($arrays)
  {
    $min_date = time();
    $max_date = 0;
    foreach($arrays as $array)
    {
      foreach($array as $key => $value)
      {
        if(strtotime($key) < $min_date)
        {
          $min_date = strtotime($key);
        }
        if(strtotime($key) > $max_date)
        {
          $max_date = strtotime($key);
        }
      }
    }
    
    $days = (($max_date - $min_date) / 24 / 60 / 60);
    
    $rtn = array();
    $counter = 0;
    foreach($arrays as $array)
    {
      $rtn[] = array();
      for($i = 0; $i < $days; $i++)
      {
        $date_temp = strtotime('+'.$i.' day', $min_date);
        if(array_key_exists(date('Y-m-d', $date_temp), $array))
        {
          $rtn[$counter][] = $array[date('Y-m-d', $date_temp)];
        } else
        {
          $rtn[$counter][] = -1;
        }
      }
      $counter++;
    }
    return $rtn;
  }

}
<?php

class Utils
{
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
        return date('Y-m-d', strtotime("$year-W$week_number-1"));
//        $time = strtotime($year . '0104 +' . ($week_number - 1) . ' weeks');
//        $monday_time = strtotime('-' . (date('w', $time) - 1) . ' days', $time);
//        return date('Y-m-d', $monday_time);
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

    public static function isUserRecord($class_name, $record_id, $user_id) {
        $class = new ReflectionClass($class_name);
        $c = new Criteria();
        $c->add($class->getConstant('USER_ID'), $user_id);
        $c->add($class->getConstant('ID'), $record_id);
        $record = $class->getMethod('doSelectOne')->invoke(null, $c);
        return $record != null;
    }
    
    public static function print_debug($exp) {
        echo "<pre>";
        print_r($exp);
        echo "</pre>";
    }

}

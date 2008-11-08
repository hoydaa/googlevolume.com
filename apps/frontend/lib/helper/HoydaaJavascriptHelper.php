<?php

sfLoader::loadHelpers(array('Javascript'));

function hoydaa_auto_complete($field_id, $url, $options = array())
{
  $response = sfContext::getInstance()->getResponse();
  
  $response->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype');
  $response->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/effects');
  $response->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/controls');
  $response->addStylesheet(sfConfig::get('sf_prototype_web_dir').'/css/input_auto_complete_tag');
  
  $div = '<div id="' . $field_id . '_auto_complete" class="auto_complete"></div>';
  return $div . _auto_complete_field($field_id, $url, $options); 
}

function hoydaa_date_array_to_date($arr)
{
  if(!$arr) {
    return null;
  }
  return $arr['year'] . '-' . _fill_with_zero($arr['month'], 2) . '-' . _fill_with_zero($arr['day'], 2);
}

function _fill_with_zero($num, $len)
{
  if(strlen($num) < $len)
  {
    for($i = 0; $i < $len - strlen($num); $i++)
    {
      $num = '0' . $num;
    }
  }
  return $num;
}
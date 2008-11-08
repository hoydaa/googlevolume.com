<?php

require_once('simple_html_dom.php');

class Google implements SearchEngine
{
  public function search($query)
  {
    $request = new HttpRequest('http://www.google.com/search', HttpRequest::METH_GET);
    $request->addQueryData(array('q' => $query));

    try
    {
      $request->send();
    }
    catch (HttpException $e)
    {
    }

    $html = str_get_html($request->getResponseBody());

    return str_replace(",", "", $html->find('div[id=ssb] p', 0)->find('b', 2)->plaintext);
  }
}
<?php

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

    //preg_match_all('/<b>\s*(\w*)\s*<\/b>/', $request->getResponseBody(), $matches);
    preg_match_all('/<b>([^<]*)/', $request->getResponseBody(), $matches);

    return str_replace(",", "", $matches[1][3]);
  }
}
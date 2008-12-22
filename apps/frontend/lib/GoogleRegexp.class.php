<?php

/**
 * Grabs search results size of a specified query from google.com using regular expression
 *
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
class GoogleRegexp implements SearchEngine
{

    public function search($query)
    {   
        $request = new HttpRequest('http://www.google.com/search', HttpRequest::METH_GET);
        $request->addQueryData(array('q' => $query));

		if (sfConfig::get('sf_logging_enabled'))
		{
  			sfContext::getInstance()->getLogger()->info(sprintf('Requesting search results for \'%s\'', $query));
		}
        
        try
        {
            $request->send();
        }
        catch (HttpException $e)
        {
        	if (sfConfig::get('sf_logging_enabled'))
			{
  				sfContext::getInstance()->getLogger()->info(sprintf('There is an error with the http request: %s', $e->__toString()));
			}
        }

        $res = $request->getResponseBody();
        $result_count = self::findResultCount($res);
        
    	if (sfConfig::get('sf_logging_enabled'))
		{
  			sfContext::getInstance()->getLogger()->info(sprintf('Found %s results for \'%s\'', $result_count, $query));
		}
        
        return $result_count;
    }
    
    //Results <b>1</b> - <b>10</b> of about <b>789</b> for <b>&quot;Umut Utkan&quot;</b>.  (<b>0.05</b> seconds)
    public static function findResultCount($content)
    {
    	$pattern = '/Results <b>1<\/b> - <b>(\d+)<\/b> of (about )?<b>([0-9,]+)<\/b>/';
    	$matches = null;
    	preg_match($pattern, $content, $matches);
    	
    	print_r($matches);
    	
		if(sizeof($matches) == 4)
		{
			return preg_replace("/,/", "", $matches[3]);
		}
    	return 0;
    }

}

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

        //change to log
        //echo "Going to send request to url: " . $request->getUrl() . " with query data: \n";
        //print_r($request->getQueryData());
        //echo "\n";
        
        try
        {
            $request->send();
        }
        catch (HttpException $e)
        {
            //change to log
            //echo sprintf("There is an error with the http request: %s\n", $e->__toString());
        }

        $res = $request->getResponseBody();
        
		return self::findResultCount($res);
    }
    
    //Results <b>1</b> - <b>10</b> of about <b>789</b> for <b>&quot;Umut Utkan&quot;</b>.  (<b>0.05</b> seconds)
    public static function findResultCount($content)
    {
    	$pattern = '/Results <b>(\d+)<\/b> - <b>(\d+)<\/b> of (about )?<b>(\d+)<\/b>/';
    	$matches = null;
    	preg_match($pattern, $content, $matches);
    	
		if(sizeof($matches) == 5)
		{
			return $matches[4];
		}
    	return 0;
    }

}

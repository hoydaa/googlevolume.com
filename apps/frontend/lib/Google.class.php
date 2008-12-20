<?php

require_once('simple_html_dom.php');

/**
 * Grabs search results size of a specified query from google.com
 *
 * @author Utku Utkan, <utku.utkan@hoydaa.org>
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
class Google implements SearchEngine
{
    
    /**
     * Gets result size
     *
     * @param string $query
     * @return string
     */
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
        
        //change to log
        //echo "Received response.\n";
        
        $html = str_get_html($res);

        return str_replace(",", "", $html->find('div[id=ssb] p', 0)->find('b', 2)->plaintext);
    }

}

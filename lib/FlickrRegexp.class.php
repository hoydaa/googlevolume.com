<?php

/**
 * Grabs search results size of a specified query from youtube.com using regular expression
 *
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
class FlickrRegexp implements SearchEngine
{

    public function search($query)
    {   
        
    }
    
    //We found <strong>3,291 results</strong>
    public static function findResultCount($content)
    {
    	$pattern = '/We found <strong>([0-9,]+) results<\/strong>/';
    	$matches = null;
    	preg_match($pattern, $content, $matches);
    	
		if(sizeof($matches) == 2)
		{
			return preg_replace("/,/", "", $matches[1]);
		}
    	return 0;
    }

}

<?php

/**
 * Grabs search results size of a specified query from youtube.com using regular expression
 *
 * @author Umut Utkan, <umut.utkan@hoydaa.org>
 */
class YoutubeRegexp implements SearchEngine
{

    public function search($query)
    {   
        
    }
    
    //<strong>1 - 20</strong> of about <strong>25,200</strong>
    public static function findResultCount($content)
    {
    	$pattern = '/<strong>1 \- (\d+)<\/strong> of about <strong>([0-9,]+)<\/strong>/';
    	$matches = null;
    	preg_match($pattern, $content, $matches);
    	
		if(sizeof($matches) == 3)
		{
			return preg_replace("/,/", "", $matches[2]);
		}
    	return 0;
    }

}

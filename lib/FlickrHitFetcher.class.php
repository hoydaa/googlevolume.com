<?php

/**
 * Grabs search results size of a specified query from flickr.com using regular expression
 *
 * @author Utku Utkan, <utku.utkan@hoydaa.org>
 */
class FlickrHitFetcher extends AbstractHitFetcher
{
    protected function getUrl()
    {
        return 'http://www.flickr.com/search/';
    }

    protected function getParamName()
    {
        return 'q';
    }

    //We found <strong>3,291 results</strong>
    public function extractHit($html)
    {
        $pattern = '/We found <strong>([0-9,]+) results<\/strong>/';

        $matches = null;

        preg_match($pattern, $html, $matches);
        
        if (sizeof($matches) == 2)
        {
            return preg_replace("/,/", "", $matches[1]);
        }

        return 0;
    }
}

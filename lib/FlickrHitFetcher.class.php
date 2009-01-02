<?php

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

    protected function extractHit($html)
    {
        $pattern = '/We found <strong>([0-9,]+) results<\/strong>/';

        $matches = null;

        preg_match($pattern, $content, $matches);

        if (sizeof($matches) == 2)
        {
            return preg_replace("/,/", "", $matches[1]);
        }

        return 0;
    }
}

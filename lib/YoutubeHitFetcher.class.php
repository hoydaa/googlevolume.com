<?php

/**
 * Grabs search results size of a specified query from youtube.com using regular expression
 *
 * @author Utku Utkan, <utku.utkan@hoydaa.org>
 */
class YoutubeHitFetcher extends AbstractHitFetcher
{
    protected function getUrl()
    {
        return 'http://www.youtube.com/results';
    }

    protected function getParamName()
    {
        return 'search_query';
    }

    //<strong>1 - 20</strong> of about <strong>25,200</strong>
    public function extractHit($html)
    {
        $pattern = '/<strong>1 \- (\d+)<\/strong> of about <strong>([0-9,]+)<\/strong>/';

        $matches = null;

        preg_match($pattern, $html, $matches);

        if (sizeof($matches) == 3)
        {
            return preg_replace("/,/", "", $matches[2]);
        }

        return 0;
    }
}

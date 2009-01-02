<?php

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

    protected function extractHit($html)
    {
        $pattern = '/<strong>1 \- (\d+)<\/strong> of about <strong>([0-9,]+)<\/strong>/';

        $matches = null;

        preg_match($pattern, $content, $matches);

        if (sizeof($matches) == 3)
        {
            return preg_replace("/,/", "", $matches[2]);
        }

        return 0;
    }
}

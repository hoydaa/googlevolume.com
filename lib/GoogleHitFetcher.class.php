<?php

class GoogleHitFetcher extends AbstractHitFetcher
{
    protected function getUrl()
    {
        return 'http://www.google.com/search';
    }

    protected function getParamName()
    {
        return 'q';
    }

    protected function extractHit($html)
    {
        $pattern = '/Results <b>1<\/b> - <b>(\d+)<\/b> of (about )?<b>([0-9,]+)<\/b>/';

        $matches = null;

        preg_match($pattern, $content, $matches);

        if (sizeof($matches) == 4)
        {
            return preg_replace("/,/", "", $matches[3]);
        }

        return 0;
    }
}

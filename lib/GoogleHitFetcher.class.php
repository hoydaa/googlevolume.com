<?php

/**
 * Grabs search results size of a specified query from google.com using regular expression
 *
 * @author Utku Utkan, <utku.utkan@hoydaa.org>
 */
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

    //Results <b>1</b> - <b>10</b> of about <b>789</b> for <b>&quot;Umut Utkan&quot;</b>.  (<b>0.05</b> seconds)
    public function extractHit($html)
    {
        $pattern = '/Results <b>1<\/b> - <b>(\d+)<\/b> of (about )?<b>([0-9,]+)<\/b>/';

        $matches = null;

        preg_match($pattern, $html, $matches);

        if (sizeof($matches) == 4)
        {
            return preg_replace("/,/", "", $matches[3]);
        }

        return 0;
    }
}

<?php

class AbstractHitFetcher implements HitFetcher
{
    protected function getUrl();

    protected function getParamName();

    protected function extractHit($html);

    public function fetch($query)
    {
        $request = new HttpRequest(self::getUrl(), HttpRequest::METH_GET);
        $request->addQueryData(array(self::getParamName() => $query));

        if (sfConfig::get('sf_logging_enabled'))
        {
            sfContext::getInstance()->getLogger()->info(sprintf('Requesting search results for \'%s\'', $query));
        }

        try
        {
            $request->send();
        }
        catch (HttpException $e)
        {
            if (sfConfig::get('sf_logging_enabled'))
            {
                sfContext::getInstance()->getLogger()->info(sprintf('There is an error with the http request: %s', $e->__toString()));
            }
        }

        $html = $request->getResponseBody();
        $hit = self::extractHit($html);

        if (sfConfig::get('sf_logging_enabled'))
        {
            sfContext::getInstance()->getLogger()->info(sprintf('Found %s results for \'%s\'', $hit, $query));
        }

        return $hit;
    }
}

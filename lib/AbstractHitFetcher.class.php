<?php

abstract class AbstractHitFetcher implements HitFetcher
{
    abstract protected function getUrl();

    abstract protected function getParamName();

    abstract public function extractHit($html);

    public function fetch($query)
    {
        $request = new HttpRequest($this->getUrl(), HttpRequest::METH_GET);
        $request->addQueryData(array($this->getParamName() => $query));

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
        $hit = $this->extractHit($html);

        if (sfConfig::get('sf_logging_enabled'))
        {
            sfContext::getInstance()->getLogger()->info(sprintf('Found %s results for \'%s\'', $hit, $query));
        }

        return $hit;
    }
}

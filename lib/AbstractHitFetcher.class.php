<?php

abstract class AbstractHitFetcher implements HitFetcher
{
    private static $providers = array();
    
    public static function getInstance($source)
    {
        if(!array_key_exists($source, self::$providers))
        {
            if($source == Query::SOURCE_GOOGLE)
            {
                self::$providers[$source] = new GoogleHitFetcher();
            } else if($source == Query::SOURCE_YOUTUBE)
            {
                self::$providers[$source] = new YoutubeHitFetcher();
            } else if($source == Query::SOURCE_FLICKR)
            {
                self::$providers[$source] = new FlickrHitFetcher();
            }
        }
        return self::$providers[$source];
    }
    
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

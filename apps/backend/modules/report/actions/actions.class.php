<?php

/**
 * report actions.
 *
 * @package    project-y
 * @subpackage report
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class reportActions extends autoreportActions
{

    protected function updateReportFromRequest() {
        $cacheManager = $this->getContext()->getViewCacheManager();
        $cacheManager->remove('@sf_cache_partial?module=report&action=_miniChart&sf_cache_key='.$this->report->getId());
    }

}

<?php

class tagComponents extends sfComponents
{
    public function executeCloud()
    {
        $this->tags = ReportTagPeer::getPopularTags();
    }
}

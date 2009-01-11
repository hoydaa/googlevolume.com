<?php

class queryComponents extends sfComponents
{   
    public function executeCloud()
    {
        $this->queries = QueryPeer::getPopularTags();
    }
}
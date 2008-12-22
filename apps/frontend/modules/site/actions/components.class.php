<?php

class siteComponents extends sfComponents
{

    public function executeStatistics($request)
    {
		$this->statistics = array('reports' => ReportPeer::doCount(new Criteria()), 
			'queries' => QueryPeer::doCount(new Criteria()), 
			'query_results' => QueryResultPeer::doCount(new Criteria()));
    }

}
<?php

/**
 * Subclass for representing a row from the 'projecty_query_result' table.
 *
 *
 *
 * @package lib.model
 */
class QueryResultBulk extends BaseQueryResultBulk
{

    // update QueryResultDaily model accordingly
    public function save($con = null)
    {
        parent::save($con);

        $c = new Criteria();
        $c->add(QueryResultPeer::RESULT_DATE, $this->getCreatedAt('Y-m-d'));
        $c->add(QueryResultPeer::QUERY_ID, $this->getQueryId());
        $daily = QueryResultPeer::doSelectOne($c);
        if($daily)
        {
            $daily->setResultSize(($daily->getResultSize() * $daily->getResultCount() + $this->getResultSize()) / ($daily->getResultCount() + 1));
            $daily->setResultCount($daily->getResultCount() + 1);
        } else
        {
            $daily = new QueryResult();
            $daily->setQueryId($this->getQueryId());
            $daily->setResultCount(1);
            $daily->setResultSize($this->getResultSize());
            $daily->setResultDate($this->getCreatedAt('Y-m-d'));
        }
        $daily->save();
    }

}

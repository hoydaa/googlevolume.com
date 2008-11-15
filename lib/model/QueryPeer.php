<?php

class QueryPeer extends BaseQueryPeer
{
  public static function retrieveByQUERY($query)
  {
    $c = new Criteria();
    $c->add(QueryPeer::QUERY, $query);
    return QueryPeer::doSelectOne($c);
  }

  public static function findUnprocessedQueries($date)
  {
    $c = new Criteria();
    $c->add(QueryResultPeer::FETCH_DATE, $date);

    $query_ids = array();
    $query_results = QueryResultPeer::doSelect($c);

    foreach ($query_results as $query_result)
    {
      $query_ids[] = $query_result->getQueryId();
    }

    $c = new Criteria();
    //$c->add(self::ID, $query_ids, Criteria::NOT_IN);

    return QueryPeer::doSelect($c);
  }

}

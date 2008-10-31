<?php

class QueryPeer extends BaseQueryPeer
{

  public static function retrieveByQUERY($query)
  {
    $c = new Criteria();
    $c->add(QueryPeer::QUERY, $query);
    return QueryPeer::doSelectOne($c);
  }

}

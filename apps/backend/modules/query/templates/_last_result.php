<?php
include_once('func.php');

$c = new Criteria();
$c->add(QueryResultPeer::QUERY_ID, $query->getId());
$c->addDescendingOrderByColumn(QueryResultPeer::CREATED_AT);
$c->setLimit(1);
$query_result = QueryResultPeer::doSelectOne($c);
echo "<span>".addTrailingSpaces(number_format($query_result->getResultSize()))."</span>";

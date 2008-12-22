<?php
	$c = new Criteria();
	$c->add(QueryResultPeer::QUERY_ID, $query->getId());
	echo QueryResultPeer::doCount($c);
?>
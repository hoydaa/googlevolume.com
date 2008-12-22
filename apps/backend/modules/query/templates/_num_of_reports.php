<?php

$c = new Criteria();
$c->add(ReportQueryPeer::QUERY_ID, $query->getId());
$c->addJoin(ReportPeer::ID, ReportQueryPeer::REPORT_ID);
echo ReportPeer::doCount($c);

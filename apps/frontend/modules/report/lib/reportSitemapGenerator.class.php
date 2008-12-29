<?php

class reportSitemapGenerator implements sitemapGenerator
{
    public static function generate()
    {
        $urls = array();

        $c = new Criteria();
        $c->add(ReportPeer::PUBLIC_RECORD, true);
        $c->addDescendingOrderByColumn(ReportPeer::CREATED_AT);

        $reports = ReportPeer::doSelect($c);

        foreach ($reports as $report)
        {
            $urls[] = new sitemapURL("report/show?id=".$report->getFriendlyUrl(), date('Y-m-d\TH:i:s\Z', strtotime($report->getCreatedAt())), 'weekly', 1.0);
        }

        return $urls;
    }
}

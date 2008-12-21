<h2><?php echo __('Actual Queries Used') ?></h2>
<ul>
    <?php foreach($report->getReportQuerys() as $report_query): ?>
	    <li><?php echo $report_query->getTitle() ?> : <a href="http://www.google.com/search?q=<?php echo urlencode($report_query->getQuery()->getQuery()) ?>"><?php echo $report_query->getQuery()->getQuery() ?></a></li>
    <?php endforeach; ?>
</ul>
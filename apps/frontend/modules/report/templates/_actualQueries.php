<h2><?php echo __('Actual Queries Used') ?></h2>
<ul>
    <?php foreach($report->getReportQuerys() as $report_query): ?>
	    <li><?php echo $report_query->getTitle() . " : " . $report_query->getQuery()->getQuery() . "<br>" ?></li>
    <?php endforeach; ?>
</ul>
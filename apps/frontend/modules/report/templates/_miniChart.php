<h2><?php echo $report->getTitle(); ?></h2>
<a href="<?php echo url_for('report/show?id=' . $report->getFriendlyUrl()) ?>">
	<img src="<?php echo $chart ?>" alt="<?php echo $report->getTitle() ?>" />
</a>
<ul class="labels">
	<?php $counter = 0; ?>
	<?php foreach($chart->getSeries()->getSeries() as $serie): ?>
	    <?php $arr = $report->getReportQuerys(); ?>
		<li>
			<div style="background-color: #<?php echo $serie->getColor() ?>"></div>
			<span><a href="http://www.google.com/search?q=<?php echo urlencode($arr[$counter++]->getQuery()->getQuery()) ?>"><?php echo $serie->getLabel() ?></a></span>
		</li>
	<?php endforeach; ?>
</ul>
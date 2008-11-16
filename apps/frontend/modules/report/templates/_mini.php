<h2><?php echo $report->getTitle(); ?></h2>
<a href="<?php echo url_for('report/show?id=' . $report->getId()) ?>">
	<img src="<?php echo $chart ?>" alt="<?php echo $report->getTitle() ?>" />
</a>
<ul class="labels">
	<?php foreach($chart->getSeries()->getSeries() as $serie): ?>
		<li>
			<div style="background-color: #<?php echo $serie->getColor() ?>"></div>
			<span><?php echo $serie->getLabel() ?></span>
		</li>
	<?php endforeach; ?>
</ul>
<h2><?php echo $report->getTitle(); ?></h2>
<a href="<?php echo url_for('report/show?id=' . $report->getId()) ?>">
	<img src="<?php echo $chart ?>" alt="<?php echo $report->getTitle() ?>" />
</a>
<ul class="labels">
	<?php foreach($labels as $label): ?>
		<li>
			<div style="background-color: <?php echo $label['color'] ?>"></div>
			<span><?php echo $label['title'] ?></span>
		</li>
	<?php endforeach; ?>
</ul>
<?php use_helper('I18N') ?>

<div class="sidebox">
	<h2>POPULAR QUERIES</h2>
	<ul class="tag_cloud">
		<?php foreach($queries as $query): ?>
			<li class="rank_<?php echo $query['rank'] ?>"><?php echo link_to($query['query'], 'query/show?query=' . urlencode($query['query']), array('title' => __(":count report(s) with query ':query'", array(':count' => $query['count'], ':query' => $query['query'])))) ?></li>
		<?php endforeach; ?>
	</ul>
	<?php echo link_to(__('View All'), 'query/list', array('title' => __('View All Queries'))) ?>
</div>
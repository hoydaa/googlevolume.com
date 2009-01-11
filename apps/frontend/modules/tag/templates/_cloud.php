<?php use_helper('I18N') ?>

<div class="sidebox">
	<h2>POPULAR TAGS</h2>
	<ul class="tag_cloud">
		<?php foreach($tags as $tag): ?>
			<li class="rank_<?php echo $tag['rank'] ?>"><?php echo link_to($tag['tag'], 'tag/show?tag=' . $tag['tag'], array('title' => __(":count report(s) with tag ':tag'", array(':count' => $tag['count'], ':tag' => $tag['tag'])))) ?></li>
		<?php endforeach; ?>
	</ul>
	<?php echo link_to(__('View All'), 'tag/list', array('title' => __('View All Tags'))) ?>
</div>
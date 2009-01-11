<?php use_helper('I18N') ?>

<h1><?php echo __('All Queries') ?></h1>

<ul class="tag_cloud">
  <?php foreach($queries as $query): ?>
    <li class="rank_<?php echo $query['rank'] ?>"><?php echo link_to($query['query'], 'query/show?query=' . $query['query'], array('title' => __(":count snippet(s) with query ':query'", array(':count' => $query['count'], ':query' => $query['query'])))) ?></li>
  <?php endforeach; ?>
</ul>
<?php
    $menu = array('By Date' => 'showByDate',
        'By Popularity' => 'showByPopularity',
        'By Stability' => 'showByStability',
        'By Data Amount' => 'showByAmount');
?>

<ul class="nav">
	<?php foreach($menu as $menu_title => $menu_action): ?>
	    <?php if($sf_request->getParameter('action') == $menu_action): ?>
    		<li>
    			<?php if($sf_request->getParameter('order') == 'asc'): ?>
    				<?php echo link_to($menu_title . ' <b> &uarr;</b>', 'report/'.$menu_action.'?order=desc', array('class' => 'sel')) ?>
    			<?php else: ?>
    				<?php echo link_to($menu_title . ' <b> &darr;</b>', 'report/'.$menu_action.'?order=asc', array('class' => 'sel')) ?>
    			<?php endif; ?>
    		</li>
        <?php else: ?>
    		<li><?php echo link_to($menu_title, 'report/'.$menu_action.'?order=desc', array('class' => 'unsel')) ?></li>
        <?php endif; ?>
	<?php endforeach; ?>
</ul>

<?php include_partial('report/pager', array('pager' => $pager)) ?>
<?php
    $menu = array('By Date' => 'showByDate',
        'By Popularity' => 'showByPopularity',
        'By Stability' => 'showByStability',
        'By Data Amount' => 'showByAmount');
?>

<ul class="tool-bar">
    <?php foreach($menu as $menu_title => $menu_action): ?>
        <li>
            <?php if($sf_request->getParameter('action') == $menu_action): ?>
                <div>
                    <?php if($sf_request->getParameter('order') == 'asc'): ?>
                        <?php echo link_to($menu_title . ' <strong>&uarr;</strong>', 'report/'.$menu_action.'?order=desc') ?>
                    <?php else: ?>
                        <?php echo link_to($menu_title . ' <strong>&darr;</strong>', 'report/'.$menu_action.'?order=asc') ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php echo link_to($menu_title, 'report/'.$menu_action.'?order=desc') ?>
            <?php endif; ?>
        </li>
	<?php endforeach; ?>
</ul>

<?php include_partial('report/pager', array('pager' => $pager)) ?>
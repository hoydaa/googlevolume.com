<ul class="nav">
    <li><span>New Reports</span></li>
    <li><?php echo link_to('Popular Reports', 'report/showPopular') ?></li>
</ul>

<?php include_partial('report/pager', array('pager' => $pager)) ?>
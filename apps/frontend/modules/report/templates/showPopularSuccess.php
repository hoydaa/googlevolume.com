<ul class="nav">
    <li><?php echo link_to('New Reports', 'report/showNew') ?></li>
    <li><span>Popular Reports</span></li>
</ul>

<?php include_partial('report/pager', array('pager' => $pager)) ?>
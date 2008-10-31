<h2><?php echo $report->getTitle() ?></h2>

<?php include_component('report', 'chart', array('report' => $report)) ?>
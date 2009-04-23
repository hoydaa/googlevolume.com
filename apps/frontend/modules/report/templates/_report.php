<?php use_helper('Javascript', 'HoydaaJavascript') ?>

<div id="report-container">
    <?php if ($report->getDescription()): ?>
        <p><?php echo $report->getDescription() ?></p>
    <?php endif; ?>
    <!-- 
	<?php echo image_tag('/' . $report->getFriendlyUrl() . '.png'); ?>
     -->
	<?php include_component('report', 'chart', array('report' => $report)) ?>
</div>
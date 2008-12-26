Created by 
<?php if($report->getSfGuardUser()): ?>
    <?php echo link_to($report->getSfGuardUser(), 'report/userReports?username=' . $report->getSfGuardUser()->getUsername())  ?>
<?php else: ?>
	anonymous
<?php endif; ?>
 on 
<?php echo $report->getCreatedAt() ?>
 with tags: 
<?php
    foreach($report->getReportTags() as $tag)
    {
        echo link_to($tag->getName(), 'tag/show?tag=' . $tag->getName()) . ", ";
    }
?>
 (viewed: <?php echo $report->getViewCount() ?> times)
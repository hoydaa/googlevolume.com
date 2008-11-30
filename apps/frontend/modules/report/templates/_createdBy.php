Created by 
<?php if($report->getSfGuardUser()): ?>
    <?php echo $report->getSfGuardUser()  ?>
<?php else: ?>
	anonymous
<?php endif; ?>
 with tags: 
<?php
    foreach($report->getReportTags() as $tag)
    {
        echo link_to($tag->getName(), 'tag/show?tag=' . $tag->getName()) . ", ";
    }
?>
<?php use_helper('I18N') ?>

<h1>
    <?php echo $report->getTitle() ?>
    <?php if($sf_user->isAuthenticated()): ?>
    	<?php if(Utils::isUserRecord('ReportPeer', $report->getId(), $sf_user->getId())): ?>
    		<?php echo ' (' . 
    		    link_to('Edit', 'report/edit?id=' . $report->getId()) . ' | ' .
    		    link_to('Delete', 'report/delete?id=' . $report->getId()) . ')' ?>
    	<?php endif; ?>
    <?php endif; ?>
</h1>

<?php include_partial('report/createdBy', array('report' => $report)) ?>

<?php include_partial('report/report', array('report' => $report, 'form' => $form)) ?>

<?php include_partial('report/actualQueries', array('report' => $report)) ?>
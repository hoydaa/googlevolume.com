<?php use_helper('I18N') ?>

<?php echo __('Are you sure you want to delete?'); ?>&nbsp;
<?php echo link_to('Yes', 'report/delete?delete=Yes&id=' . $report->getId()) . ' ' . link_to('No', 'report/show?id=' . $report->getFriendlyUrl()); ?>

<?php include_partial('report/reportPage', array('report' => $report, 'form' => $form)) ?>
<?php use_helper('I18N') ?>

<h1><?php echo __('Reports tagged with %tag%.', array('%tag%' => $sf_request->getParameter('tag'))) ?></h1>

<?php include_partial('report/pager', array('pager' => $pager)) ?>
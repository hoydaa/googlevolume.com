<?php use_helper('I18N') ?>

<h1><?php echo __('Reports with query %query%.', array('%query%' => $sf_request->getParameter('query'))) ?></h1>

<?php include_partial('report/pager', array('pager' => $pager)) ?>
<?php include_partial('mail/headerText', array('full_name' => $full_name)) ?>

In the attachments you can find the report you requested for report <?php echo $title ?>.

<?php include_partial('mail/footerText') ?>

----------
If you want to disable this mail, go to url <?php echo sfConfig::get('app_homepage_url') ?>/report/show/id/<?php $report->getFriendlyUrl() ?>, 
login if you are not, and click edit report to select None as frequency.
<?php include_partial('mail/headerHtml', array('full_name' => $full_name)) ?>

<p>The following is the report you requested for <?php echo $title ?></p>

<img src="<?php echo $images['report']; ?>" alt="<?php echo $title ?>" />

<?php include_partial('mail/footerHtml') ?>

<p>----------</p>

<p>If you want to disable this mail, click <a href="<?php echo sfConfig::get('app_homepage_url') ?>/report/show/id/<?php echo $report->getFriendlyUrl() ?>">here</a>, login if you are not, and click edit report to select None as frequency.</p>
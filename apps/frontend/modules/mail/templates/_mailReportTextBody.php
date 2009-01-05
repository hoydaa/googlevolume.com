<?php include_partial('mail/headerText', array('full_name' => $full_name)) ?>

In the attachments you can find the reports you requested for <?php echo implode(', ', array_keys($images)) ?>.

<?php include_partial('mail/footerText') ?>

----------
If you want to disable this mail, click <a href="<?php echo sfConfig::get('app_homepage_url') ?>">here</a>, 
login if you are not, and edit related reports to change mail frequency to Never.
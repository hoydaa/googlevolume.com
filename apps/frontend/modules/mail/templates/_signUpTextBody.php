<?php include_partial('mail/headerText', array('full_name' => $full_name)) ?>

Click the link below to verify your e-mail address and activate your account.

<?php echo url_for('user/confirmation?key=' . $activation_key, array('absolute' => true)) . "\n" ?>

<?php include_partial('mail/footerText') ?>
Confirm your email address!
Dear <?php echo $full_name ?>,
Click the link below to verify your e-mail address and activate your account.
<?php echo url_for('user/confirmation?key=' . $activation_key, array('absolute' => true)) . "\n" ?>
Thanks for signing up.
GoogleVolume Team
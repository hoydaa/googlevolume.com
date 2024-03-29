<?php include_partial('mail/headerText', array('full_name' => $full_name)) ?>

For safety reasons, the googlevolume website does not store passwords in clear text.
When you forget your password, googlevolume creates a new one that can be used in place.

You can now login to googlevolume with:

username: <?php echo "$username\n" ?>
password: <?php echo "$password\n" ?>

To get connected, go to the login page 
(<?php echo url_for('@sf_guard_signin', array('absolute' => 'true')) ?>)
and use your username and password.

<?php include_partial('mail/footerText') ?>
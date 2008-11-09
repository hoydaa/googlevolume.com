Dear <?php echo $full_name ?>,

For safety reasons, the snippets website does not store passwords in clear text.
When you forget your password, snippets creates a new one that can be used in place.

You can now login to snippets with:

username: <?php echo "$username\n" ?>
password: <?php echo "$password\n" ?>

To get connected, go to the login page 
(<?php echo url_for('@sf_guard_signin', array('absolute' => 'true')) ?>)
and use your username and password.

We hope to see you soon on snippets!

Hoydaa Snippets Team
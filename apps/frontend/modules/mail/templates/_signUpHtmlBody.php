<?php include_partial('mail/headerHtml', array('full_name' => $full_name)) ?>

<p>Click the link below to verify your e-mail address and activate your account.</p>

<p><?php echo link_to('Verify my account', 
	'user/confirmation?key=' . $activation_key, array('absolute' => true)) ?></p>

<?php include_partial('mail/footerHtml') ?>
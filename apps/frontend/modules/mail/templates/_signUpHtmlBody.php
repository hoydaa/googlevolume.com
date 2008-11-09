<p>Confirm your email address!</p>
<p>Dear <?php echo $full_name ?>,</p>
<p>Click the link below to verify your e-mail address and activate your account.</p>
<p><?php echo link_to('Verify my account', 
	'user/confirmation?key=' . $activation_key, array('absolute' => true)) ?></p>
<p>Thanks for signing up.</p>
<p>Hoydaa Snippets Team</p>
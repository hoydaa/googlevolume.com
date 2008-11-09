<p>Dear <?php echo $full_name ?>,</p>

<p>For safety reasons, the snippets website does not store passwords in clear text.
When you forget your password, snippets creates a new one that can be used in place.</p>

<p>You can now login to snippets with:</p>

<p>
	username: <strong><?php echo $username ?></strong><br/>
	password: <strong><?php echo $password ?></strong>
</p>

<p>To get connected, go to the <?php echo link_to('login', '@sf_guard_signin', array('absolute' => 'true')) ?> 
page and use your username and password.</p>

<p>We hope to see you soon on snippets!</p>

<p>Hoydaa Snippets Team</p>
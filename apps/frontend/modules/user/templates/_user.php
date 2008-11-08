<div class="sidebox">
	<h2>USER</h2>
	<p>Welcome <?php echo link_to($sf_user->getGuardUser()->getUsername(), 'user/viewProfile?username=' . $sf_user->getGuardUser()->getUsername(), array('title' => 'View Profile')) ?>!<p/>
	<ul>
		<li><?php echo link_to('Account settings', 'user/showAccountSettings') ?></li>
		<li><?php echo link_to('Sign Out', '@sf_guard_signout') ?></li>
	</ul>
</div>
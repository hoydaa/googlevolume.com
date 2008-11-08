<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" class="panel">
	<?php echo $form ?>
	<div class="right_col">
		<input type="submit" value="Sign In" />
	</div>
	<div class="right_col">
		<a href="<?php echo url_for('@sf_guard_password') ?>">Forgot your password?</a>
	</div>
</form>
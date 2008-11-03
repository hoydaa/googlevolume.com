<?php if ($sf_user->hasFlash('info')): ?>
	<p class="info"><?php echo $sf_user->getFlash('info') ?></p>
<?php else: ?>
	<p class="error"><?php echo $sf_user->getFlash('error') ?></p>
<?php endif; ?>
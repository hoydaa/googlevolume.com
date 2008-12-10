<h1>Change Email Address</h1>

<form action="<?php echo url_for('user/changeEmail') ?>" method="post" class="panel">
    <?php echo $form ?>
    <div class="right_col">
        <input type="submit" value="Submit" /> <?php echo link_to('Cancel', 'user/showAccountSettings') ?>
    </div>
</form>
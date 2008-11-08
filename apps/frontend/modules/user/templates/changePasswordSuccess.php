<h1>Change Password</h1>

<form action="<?php echo url_for('user/changePassword') ?>" method="post" class="panel">
    <?php echo $form ?>
    <div class="right_col">
        <input type="submit" value="Submit" />
    </div>
</form>
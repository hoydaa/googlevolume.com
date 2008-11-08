<h1>Account Settings</h1>

<form action="<?php echo url_for('user/updateAccountSettings') ?>" method="post" class="panel">
    <?php echo $form ?>
    <div class="right_col">
        <input type="submit" value="Update" />
    </div>
</form>
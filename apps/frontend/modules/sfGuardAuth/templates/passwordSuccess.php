<h1>Request Password</h1>

<form action="<?php echo url_for('@sf_guard_password') ?>" method="post" class="panel">
    <?php echo $form ?>
    <div class="right_col">
        <input type="submit" value="Submit" />
    </div>
</form>
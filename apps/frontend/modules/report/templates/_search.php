<form name="form" action="<?php echo url_for('report/search') ?>" method="post">
    <div style="float: left; margin-right: 10px;">
        <?php echo $search_form['query'] ?>
        <?php echo $search_form['page'] ?>
        <?php if($sf_user->isAuthenticated()): ?>
            <div style="margin-top: 10px;">
                <?php echo $search_form['source'] ?>
            </div>
        <?php endif; ?>
    </div>
    <input type="submit" value="Search" />
</form>
<span style="display: block; clear: left;" />
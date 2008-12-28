<form name="form" action="<?php echo url_for('report/search') ?>" method="post">
    <?php echo $search_form['query'] ?>
    <?php echo $search_form['page'] ?>
    <input type="submit" value="Search" />
</form>
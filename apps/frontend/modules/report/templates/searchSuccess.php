<?php use_helper('I18N') ?>

<h1>Search Report</h1>

<form name="form" action="<?php echo url_for('report/search') ?>" method="post" class="panel">
    <?php echo $search_form ?>
    <div class="right_col">
        <input type="submit" value="Search" />
    </div>

    <?php if (isset($pager)): ?>
        <?php include_partial('report/pager', array('pager' => $pager)) ?>
    <?php endif; ?>
</form>
<?php use_helper('I18N', 'HoydaaJavascript') ?>

<h1><?php echo __('Create/Edit Report') ?></h1>

<form action="<?php echo url_for('report/update') ?>" method="post" class="panel">
    <?php echo $form ?>
    <div class="right_col">
        <input type="submit" value="Save" />
    </div>
</form>

<?php echo hoydaa_auto_complete('report_tags', 'tag/autocomplete', array('use_style' => 'true', 'tokens' => ',')) ?>
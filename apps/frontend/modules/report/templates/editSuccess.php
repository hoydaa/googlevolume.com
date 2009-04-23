<?php use_helper('I18N') ?>

<h1><?php echo __('Create Report') ?></h1>

<form action="<?php echo url_for('report/update') ?>" method="post" class="panel">
    <?php echo $form['title']->renderRow() ?>
    <?php echo $form['description']->renderRow() ?>
    <div class="row">
        <label><?php echo __('Queries (text | label)') ?></label>
        <div class="right_col">
            <?php include_partial('report/query', array('form' => $form, 'no' => 1)) ?>
            <?php for ($i = 0, $no = 2; $i < 9; $i++): ?>
                <?php if ($form['query_text_' . $no]->getValue() != null || $form['query_label_' . $no]->getValue() != null): ?>
                    <?php include_partial('report/query', array('form' => $form, 'no' => $no)) ?>
                    <?php $no++ ?>
                <?php endif; ?>
            <?php endfor; ?>
            <div class="row query" style="display: none;">
                <input type="text" /> | <input type="text" class="medium" /> <a class="button delete-button"><?php echo __('Delete') ?></a>
            </div>
            <div class="row">
                <a class="button add-button"><?php echo __('Add Query') ?></a>
            </div>
        </div>
    </div>
    <div class="row right_col">
        <input type="submit" value="Save" class="save-button" />
    </div>
</form>
<?php use_helper('I18N') ?>

<div class="row query">
    <?php echo $form['query_text_' . $no]->renderError() ?>
    <?php echo $form['query_label_' . $no]->renderError() ?>
    <?php echo $form['query_text_' . $no]->render() ?> | <?php echo $form['query_label_' . $no]->render(array('class' => 'medium')) ?> <a class="button delete-button"><?php echo __('Delete') ?></a>
</div>
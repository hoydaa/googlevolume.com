<?php use_helper('I18N', 'Date') ?>

<h1><?php echo __('Account Settings') ?></h1>

<div class="panel">
    <div class="row">
        <label><?php echo __('First Name') ?></label>
        <?php echo $sf_params->get('first_name') ?>
    </div>
    <div class="row">
        <label><?php echo __('Last Name') ?></label>
        <?php echo $sf_params->get('last_name') ?>
    </div>
    <div class="row">
        <label><?php echo __('Gender') ?></label>
        <?php echo $sf_params->get('gender') ? $sf_params->get('gender') : '-' ?>
    </div>
    <div class="row">
        <label><?php echo __('Birthday') ?></label>
        <?php echo $sf_params->get('birthday') ? format_date($sf_params->get('birthday')) : '-' ?>
    </div>
    <div class="right-col">
        <?php echo link_to(__('Edit'), 'user/updateAccountSettings') ?><br />
    </div>
</div>
<div class="hr"></div>
<ul>
    <li><?php echo link_to(__('Change email address'), 'user/changeEmail') ?></li>
    <li><?php echo link_to(__('Change password'), 'user/changePassword') ?></li>
</ul>
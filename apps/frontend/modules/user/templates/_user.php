<?php use_helper('I18N') ?>

<div class="sidebox">
    <h2><?php echo __('USER') ?></h2>
    <p>Welcome <?php echo link_to($sf_user->getGuardUser()->getUsername(), 'report/userReports?username=' . $sf_user->getGuardUser()->getUsername(), array('title' => 'View Profile')) ?>!<p/>
    <ul>
        <li><?php echo link_to(__('My Reports'), 'report/listMyReports', array('title' => 'my reports')) ?> (<?php echo $all ?>)
            <ul>
                <li><?php echo link_to(__('Public'), 'report/listMyPublicReports') ?> (<?php echo $public ?>)</li>
                <li><?php echo link_to(__('Private'), 'report/listMyPrivateReports') ?> (<?php echo $private ?>)</li>
            </ul>
        </li>
        <li><?php echo link_to(__('Account Settings'), 'user/showAccountSettings', array('title' => 'account settings')) ?></li>
        <li><?php echo link_to(__('Your Feed'), 'report/myFeed?username='.$sf_user->getGuardUser()->getUsername()) ?></li>
        <li><?php echo link_to(__('Sign Out'), '@sf_guard_signout', array('title' => 'sign out')) ?></li>
    </ul>
</div>
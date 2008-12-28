<!DOCTYPE html PUBLIC
	"-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
    </head>
    <body>
        <div id="header-wrapper">
            <div id="header">
            	<?php include_partial('site/logo') ?>
            	<br/>
                <?php include_component('site', 'statistics') ?>
                <br />
                <?php include_component('report', 'search') ?>
            </div>
            <ul id="nav">
            	<li><?php echo link_to('Create New', 'report/edit', array('title' => 'create new report')) ?></li>
            	<?php if(!$sf_user->isAuthenticated()): ?>
            		<li><?php echo link_to('Sign In', '@sf_guard_signin', array('title' => 'sign in')) ?></li>
            		<li><?php echo link_to('Sign Up', 'user/signUp', array('title' => 'sign up')) ?></li>
            	<?php else: ?>
            		<li><?php echo link_to('Sign Out', '@sf_guard_signout', array('title' => 'sign out')) ?></li>
            	<?php endif; ?>
            	<li><?php echo link_to('Search', 'report/search', array('title' => 'search')) ?></li>
            </ul>
            <ul id="tabs">
                <li><?php echo link_to('Newest', 'report/showNew') ?></li>
                <li><?php echo link_to('Popular', 'report/showPopular') ?></li>
                <li><?php echo link_to('Most discussed', 'site/discussed') ?></li>
            </ul>
        </div>
        <div id="main-wrapper">
            <div id="main">
                <div id="sidebar">
                    <?php if($sf_user->isAuthenticated()): ?>
                        <?php include_component('user', 'user') ?>
                    <?php endif; ?>
                    <?php include_component('tag', 'cloud') ?>
                </div>
                <div id="content">
                    <?php echo $sf_content ?>
                </div>
            </div>
        </div>
        <div id="footer-wrapper">
            <div id="footer">
                <p>Copyright &copy; <?php echo date("Y") ?> <?php echo link_to('Hoydaa Inc.', 'http://www.hoydaa.org', array('target' => '_blank', 'title' => 'deliver few, deliver complete')) ?> All rights reserved.</p>
            </div>
        </div>
    </body>
</html>

<?php include_partial('mail/headerHtml', array('full_name' => $full_name)) ?>

<p>The following is the reports you requested for <?php echo implode(', ', array_keys($images)) ?>.</p>

<?php foreach($images as $title => $image): ?>
	<img src="<?php echo $image; ?>" alt="<?php echo $title ?>" /><br/><br/>
<?php endforeach; ?>

<?php include_partial('mail/footerHtml') ?>

<p>----------</p>

<p>If you want to disable this mail, click <a href="<?php echo sfConfig::get('app_homepage_url') ?>">here</a>, login if you are not, and edit related reports to change mail frequency to Never.</p>
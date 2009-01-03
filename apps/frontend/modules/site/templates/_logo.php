<?php
    $google = new GoogleHitFetcher();
    $volume_hit = $google->fetch('volume');
    $google_hit = $google->fetch('google');
    $volume_percent = $volume_hit / ($volume_hit + $google_hit) * 100;
    $google_percent = 100 - $volume_percent;
?>

<a href="<?php echo url_for('@homepage') ?>">
	<img src="http://chart.apis.google.com/chart?chf=bg,s,00000000&cht=p3&chd=t:<?php echo $google_percent ?>,<?php echo $volume_percent ?>&chs=250x100&chl=Google|Volume" />
</a>

<img src="/images/beta.png" id="beta-icon" />
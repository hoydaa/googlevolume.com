<?php
    $google = new GoogleRegexp();
    $volume_hit = $google->search('volume');
    $google_hit = $google->search('google');
    $volume_percent = $volume_hit / ($volume_hit + $google_hit) * 100;
    $google_percent = 100 - $volume_percent;
?>

<img src="http://chart.apis.google.com/chart?cht=p3&chd=t:<?php echo $google_percent ?>,<?php echo $volume_percent ?>&chs=250x100&chl=Google|Volume" />
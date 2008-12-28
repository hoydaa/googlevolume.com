<?php for ($i = 0; $i < sizeof($reports); $i++): ?>
    <div style="float: left;">
        <?php include_component('report', 'miniChart', array('report' => $reports[$i], 'sf_cache_key' => $reports[$i]->getId())); ?>
    </div>
    <?php if (++$i < sizeof($reports)): ?>
        <div style="float: right;">
            <?php include_component('report', 'miniChart', array('report' => $reports[$i], 'sf_cache_key' => $reports[$i]->getId())); ?>
        </div>
    <?php endif; ?>
    <br style="clear: both;" />
<?php endfor; ?>
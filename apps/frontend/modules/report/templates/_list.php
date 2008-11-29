<ul class="pager-res">
    <?php foreach ($reports as $report): ?>
        <li><?php echo $report->getTitle() ?></li>
        <?php include_component('report', 'miniChart', array('report' => $report)); ?>
    <?php endforeach; ?>
</ul>
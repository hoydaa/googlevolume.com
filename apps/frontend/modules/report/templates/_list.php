<ul class="pager-res">
    <?php foreach ($reports as $report): ?>
        <li><?php echo $report->getTitle() ?></li>
    <?php endforeach; ?>
</ul>
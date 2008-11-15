<?php use_helper('I18N') ?>

<h1>Search Report</h1>

<form name="form" action="<?php echo url_for('report/search') ?>" method="post" class="panel">
    <?php echo $form ?>
    <div class="right_col">
        <input type="submit" value="Search" />
    </div>

    <?php if (isset($pager)): ?>
        <ul class="pager-res">
            <?php foreach ($pager->getResults() as $report): ?>
                <li><?php echo $report->getTitle() ?></li>
            <?php endforeach; ?>
        </ul>
        <?php if ($pager->haveToPaginate()): ?>
            <ul class="pager-nav">
                <?php if ($pager->getPage() != $pager->getPreviousPage()): ?>
                    <li><a href="javascript:document.form.submit();" onclick="document.getElementById('searchreport_page').value = <?php echo $pager->getPreviousPage() ?>;"><?php echo __('Prev') ?></a></li>
                <?php endif ?>
                <?php foreach ($pager->getLinks() as $page): ?>
                    <?php if ($page == $pager->getPage()): ?>
                        <li><span><?php echo $page ?></span></li>
                    <?php else: ?>
                        <li><a href="javascript:document.form.submit();" onclick="document.getElementById('searchreport_page').value = <?php echo $page ?>;"><?php echo $page ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if ($pager->getPage() != $pager->getNextPage()): ?>
                    <li><a href="javascript:document.form.submit();" onclick="document.getElementById('searchreport_page').value = <?php echo $pager->getNextPage() ?>;"><?php echo __('Next') ?></a></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
</form>
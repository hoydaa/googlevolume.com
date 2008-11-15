<?php use_helper('I18N') ?>

<h1><?php echo __('Reports tagged with %tag%.', array('%tag%' => $sf_request->getParameter('tag'))) ?></h1>

<?php include_partial('report/list', array('reports' => $pager->getResults())) ?>

<?php if ($pager->haveToPaginate()): ?>
    <ul class="pager-nav">
        <?php if ($pager->getPage() != $pager->getPreviousPage()): ?>
            <li><?php echo link_to(__('Prev'), 'tag/show?tag=' . $sf_request->getParameter('tag') . '&page=' . $pager->getPreviousPage()) ?></li>
        <?php endif ?>
        <?php foreach ($pager->getLinks() as $page): ?>
            <?php if ($page == $pager->getPage()): ?>
                <li><span><?php echo $page ?></span></li>
            <?php else: ?>
                <li><?php echo link_to($page, 'tag/show?tag=' . $sf_request->getParameter('tag') . '&page=' . $page) ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($pager->getPage() != $pager->getNextPage()): ?>
            <li><?php echo link_to(__('Next'), 'tag/show?tag=' . $sf_request->getParameter('tag') . '&page=' . $pager->getNextPage()) ?></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
<?php use_helper('I18N') ?>

<?php
    $sf_controller = $sf_context->getController();
    $params = $sf_request->getParameterHolder()->getAll();
?>

<?php include_partial('report/list', array('reports' => $pager->getResults())) ?>

<?php if ($pager->haveToPaginate()): ?>
    <ul class="pager-nav">
        <?php if ($pager->getPage() != $pager->getPreviousPage()): ?>
            <li><a href="<?php echo $sf_controller->genUrl(array_merge($params, array('page' => $pager->getPreviousPage())))?>"><?php echo __('Prev') ?></a></li>
        <?php endif ?>
        <?php foreach ($pager->getLinks() as $page): ?>
            <?php if ($page == $pager->getPage()): ?>
                <li><span><?php echo $page ?></span></li>
            <?php else: ?>
                <li><a href="<?php echo $sf_controller->genUrl(array_merge($params, array('page' => $page)))?>"><?php echo $page ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($pager->getPage() != $pager->getNextPage()): ?>
            <li><a href="<?php echo $sf_controller->genUrl(array_merge($params, array('page' => $pager->getNextPage())))?>"><?php echo __('Next') ?></a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
<?php sfContext::getInstance()->getResponse()->setTitle(
        sfContext::getInstance()->getResponse()->getTitle() . ' :: ' . $report->getTitle()); ?>

<?php include_partial('report/reportPage', array('report' => $report, 'form' => $form)) ?>
<table>
    <tr>
        <td>
            <?php echo $report->getTitle(); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo hoydaa_link_to_overlib(
                image_tag(
                    $chart, 
                    array('alt' => $report->getTitle(), 'style' => 'border-style: none;')), 
                'report/show?id=' . $report->getId(), 
                get_serie_label_content($chart)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php foreach($chart->getSeries()->getSeries() as $serie): ?>
                <span style="background-color: #<?php echo $serie->getColor() ?>"><?php echo $serie->getLabel() ?></span>
            <?php endforeach; ?>
        </td>
    </tr>
</table>
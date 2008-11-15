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
                get_serie_label_content($labels)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php foreach($labels as $label): ?>
                <span style="background-color: <?php echo $label['color'] ?>"><?php echo $label['title'] ?></span>
            <?php endforeach; ?>
        </td>
    </tr>
</table>
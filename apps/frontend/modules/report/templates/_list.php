<table id="reports">
    <?php for ($i = 0; $i < sizeof($reports); $i++): ?>
        <tr>
            <td width="50%">
                <?php include_component('report', 'miniChart', array('report' => $reports[$i], 'sf_cache_key' => $reports[$i]->getId())); ?>
            </td>
            <td width="50%">
                <?php if (++$i < sizeof($reports)): ?>
                    <?php include_component('report', 'miniChart', array('report' => $reports[$i], 'sf_cache_key' => $reports[$i]->getId())); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endfor; ?>
</table>